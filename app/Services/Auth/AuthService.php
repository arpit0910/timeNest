<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Actions\IssueJwtAction;
use App\Enums\AuthGuard;
use App\Enums\MembershipStatus;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Logging\ActivityLog;
use App\Models\Membership\CorpMembership;
use App\Models\Membership\PlatformMembership;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * AuthService — handles all authentication business logic.
 *
 * Responsible for: login, registration, logout, token refresh,
 * workspace selection/switching, Google OAuth, and 2FA orchestration.
 *
 * Controllers NEVER contain business logic — they delegate here.
 */
class AuthService
{
    public function __construct(
        private readonly IssueJwtAction $issueJwtAction,
    ) {}

    /**
     * Authenticate a user with email and password.
     *
     * @param string $email
     * @param string $password
     * @param string|null $ip
     * @param string|null $userAgent
     * @return array Authentication result with tokens or intermediate state
     *
     * @throws AuthenticationException
     */
    public function login(string $email, string $password, ?string $ip = null, ?string $userAgent = null): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !$user->password || !Hash::check($password, $user->password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        if (!$user->is_active) {
            throw new AuthenticationException('Account has been deactivated');
        }

        if (!$user->email_verified_at) {
            return [
                'status'            => 'email_not_verified',
                'message'           => 'Please verify your email address',
                'requires_verification' => true,
            ];
        }

        // Check 2FA
        if ($user->two_factor_enabled) {
            $tempToken = $this->issueJwtAction->issueTempToken($user, '2fa');
            return [
                'status'       => 'requires_2fa',
                'message'      => 'Two-factor authentication required',
                'requires_2fa' => true,
                'temp_token'   => $tempToken,
            ];
        }

        // Update login tracking
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);

        return $this->resolveWorkspaceAndIssueTokens($user, $ip, $userAgent);
    }

    /**
     * Register a new user account.
     *
     * @param array $data Validated registration data
     * @return array Registration result with verification token info
     */
    public function register(array $data): array
    {
        $verificationToken = Str::random(64);

        $user = DB::transaction(function () use ($data, $verificationToken) {
            return User::create([
                'name'                     => $data['name'],
                'email'                    => $data['email'],
                'password'                 => $data['password'],
                'password_set'             => true,
                'first_name'              => $data['first_name'] ?? null,
                'last_name'               => $data['last_name'] ?? null,
                'phone'                    => $data['phone'] ?? null,
                'timezone'                 => $data['timezone'] ?? 'UTC',
                'locale'                   => $data['locale'] ?? 'en',
                'email_verification_token' => hash('sha256', $verificationToken),
                'is_active'                => true,
                'token_version'            => 1,
            ]);
        });

        $this->logActivity($user, 'registered', 'User account created');

        // TODO: Dispatch email verification job (Phase 5)

        return [
            'status'  => 'registered',
            'message' => 'Registration successful. Please check your email to verify your account.',
            'user'    => $user,
        ];
    }

    /**
     * Log out the authenticated user.
     *
     * Invalidates the current JWT and optionally revokes the refresh token.
     *
     * @param User $user
     * @param string|null $refreshToken Raw refresh token to revoke
     * @return void
     */
    public function logout(User $user, ?string $refreshToken = null): void
    {
        // Invalidate the current JWT (adds jti to blacklist)
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception) {
            // Token may already be invalid — safe to ignore
        }

        // Revoke refresh token if provided
        if ($refreshToken) {
            $this->issueJwtAction->revokeRefreshToken($refreshToken);
        }

        $this->logActivity($user, 'logout', 'User logged out');
    }

    /**
     * Logout from all devices by revoking all refresh tokens and incrementing token_version.
     *
     * @param User $user
     * @return void
     */
    public function logoutAllDevices(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->incrementTokenVersion();
            $this->issueJwtAction->revokeAllRefreshTokens($user->id);
        });

        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception) {
            // Safe to ignore
        }

        $this->logActivity($user, 'logout_all_devices', 'Logged out from all devices');
    }

    /**
     * Refresh an access token using a valid refresh token.
     *
     * @param string $rawRefreshToken
     * @return array New access + refresh tokens
     *
     * @throws AuthenticationException
     */
    public function refreshAccessToken(string $rawRefreshToken): array
    {
        $refreshTokenRecord = $this->issueJwtAction->validateRefreshToken($rawRefreshToken);

        if (!$refreshTokenRecord) {
            throw new AuthenticationException('Invalid or expired refresh token');
        }

        $user = $refreshTokenRecord->user;

        if (!$user || !$user->is_active) {
            $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);
            throw new AuthenticationException('Account is no longer active');
        }

        // Determine guard and corporation context from the refresh token
        $guard = AuthGuard::from($refreshTokenRecord->guard);
        $corporation = $refreshTokenRecord->corporation_id
            ? Corporation::find($refreshTokenRecord->corporation_id)
            : null;

        // For corp guard, verify membership is still active
        if ($guard === AuthGuard::Corp && $corporation) {
            $membership = CorpMembership::active()
                ->where('user_id', $user->id)
                ->where('corporation_id', $corporation->id)
                ->first();

            if (!$membership) {
                $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);
                throw new AuthenticationException('Corporation membership is no longer active');
            }

            $roleName = $user->roles()
                ->where('model_has_roles.corporation_id', $corporation->id)
                ->where('roles.corporation_id', $corporation->id)
                ->first()?->name;
        } elseif ($guard === AuthGuard::Platform) {
            $platformMembership = PlatformMembership::active()
                ->where('user_id', $user->id)
                ->first();

            if (!$platformMembership) {
                $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);
                throw new AuthenticationException('Platform access is no longer active');
            }

            $roleName = $user->roles()
                ->whereNull('model_has_roles.corporation_id')
                ->whereNull('roles.corporation_id')
                ->first()?->name;
        } else {
            $roleName = null;
        }

        // Rotate: revoke old refresh token, issue new pair
        $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);

        $accessToken = $this->issueJwtAction->issueAccessToken($user, $corporation, $guard, $roleName);
        $newRefreshToken = $this->issueJwtAction->issueRefreshToken($user, $corporation, $guard);

        return [
            'access_token'  => $accessToken,
            'refresh_token' => $newRefreshToken,
            'token_type'    => 'bearer',
            'expires_in'    => config('jwt.ttl') * 60,
        ];
    }

    /**
     * Select a corporation workspace and issue corp-guard tokens.
     *
     * Used after login when user has multiple corp memberships,
     * or to switch between corporations.
     *
     * @param User $user
     * @param string $corporationUuid
     * @param bool $switchMode If true, revoke existing tokens for previous corp
     * @return array Tokens and corporation info
     *
     * @throws AuthenticationException
     */
    public function selectCorporation(User $user, string $corporationUuid, bool $switchMode = false): array
    {
        $corporation = Corporation::where('uuid', $corporationUuid)
            ->active()
            ->firstOrFail();

        $membership = CorpMembership::active()
            ->where('user_id', $user->id)
            ->where('corporation_id', $corporation->id)
            ->first();

        if (!$membership) {
            throw new AuthenticationException('You do not have an active membership in this corporation');
        }

        $role = $user->roles()
            ->where('model_has_roles.corporation_id', $corporation->id)
            ->where('roles.corporation_id', $corporation->id)
            ->first();

        if (!$role) {
            throw new AuthenticationException('No role assigned for this corporation');
        }

        if ($role->guard_name !== 'api') {
            throw new AuthenticationException('Invalid role guard for corporation access');
        }

        // If switching, invalidate current JWT
        if ($switchMode) {
            try {
                JWTAuth::invalidate(JWTAuth::getToken());
            } catch (\Exception) {
                // Safe to ignore
            }
        }

        $accessToken = $this->issueJwtAction->issueAccessToken(
            $user, $corporation, AuthGuard::Corp, $role->name
        );
        $refreshToken = $this->issueJwtAction->issueRefreshToken(
            $user, $corporation, AuthGuard::Corp
        );

        $this->logActivity($user, 'corporation_selected', "Selected corporation: {$corporation->legal_name}", $corporation->id);

        return [
            'access_token'  => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type'    => 'bearer',
            'expires_in'    => config('jwt.ttl') * 60,
            'corporation'   => $corporation,
            'role'          => $role->name,
        ];
    }

    /**
     * Get all active workspaces (corporations) for a user.
     *
     * @param User $user
     * @return array
     */
    public function getWorkspaces(User $user): array
    {
        $corpMemberships = CorpMembership::active()
            ->where('user_id', $user->id)
            ->with(['corporation:id,uuid,legal_name,trading_name,slug,logo_url'])
            ->get();

        $platformMembership = PlatformMembership::active()
            ->where('user_id', $user->id)
            ->first();

        $platformRole = $user->roles()
            ->whereNull('model_has_roles.corporation_id')
            ->whereNull('roles.corporation_id')
            ->first();

        return [
            'corporations' => $corpMemberships->map(function ($m) use ($user) {
                $role = $user->roles()
                    ->where('model_has_roles.corporation_id', $m->corporation_id)
                    ->where('roles.corporation_id', $m->corporation_id)
                    ->first();
                return [
                    'corporation_uuid' => $m->corporation->uuid,
                    'legal_name'       => $m->corporation->legal_name,
                    'trading_name'     => $m->corporation->trading_name,
                    'slug'             => $m->corporation->slug,
                    'logo_url'         => $m->corporation->logo_url,
                    'role'             => $role?->name,
                    'joined_at'        => $m->joined_at?->toISOString(),
                ];
            }),
            'has_platform_access' => $platformMembership !== null,
            'platform_role'       => $platformRole?->name,
        ];
    }

    /**
     * Handle Google OAuth callback — find or create user, link social account.
     *
     * @param SocialiteUser $socialiteUser
     * @param string|null $ip
     * @param string|null $userAgent
     * @return array Authentication result
     */
    public function handleGoogleCallback(SocialiteUser $socialiteUser, ?string $ip = null, ?string $userAgent = null): array
    {
        $user = DB::transaction(function () use ($socialiteUser) {
            // 1. Check social_accounts by provider + provider_id
            $socialAccount = SocialAccount::where('provider', 'google')
                ->where('provider_id', $socialiteUser->getId())
                ->first();

            if ($socialAccount) {
                // Update tokens
                $socialAccount->update([
                    'access_token'     => $socialiteUser->token,
                    'refresh_token'    => $socialiteUser->refreshToken,
                    'token_expires_at' => $socialiteUser->expiresIn
                        ? now()->addSeconds($socialiteUser->expiresIn)
                        : null,
                    'provider_name'    => $socialiteUser->getName(),
                    'provider_avatar'  => $socialiteUser->getAvatar(),
                ]);

                return $socialAccount->user;
            }

            // 2. Check users by email
            $user = User::where('email', $socialiteUser->getEmail())->first();

            if (!$user) {
                // 3. Create new user (OAuth-only, no password)
                $user = User::create([
                    'name'              => $socialiteUser->getName() ?? $socialiteUser->getEmail(),
                    'email'             => $socialiteUser->getEmail(),
                    'password'          => null,
                    'password_set'      => false,
                    'email_verified_at' => now(), // Google email is pre-verified
                    'avatar_url'        => $socialiteUser->getAvatar(),
                    'is_active'         => true,
                    'token_version'     => 1,
                ]);
            }

            // Link social account
            SocialAccount::create([
                'user_id'          => $user->id,
                'provider'         => 'google',
                'provider_id'      => $socialiteUser->getId(),
                'provider_email'   => $socialiteUser->getEmail(),
                'provider_name'    => $socialiteUser->getName(),
                'provider_avatar'  => $socialiteUser->getAvatar(),
                'access_token'     => $socialiteUser->token,
                'refresh_token'    => $socialiteUser->refreshToken,
                'token_expires_at' => $socialiteUser->expiresIn
                    ? now()->addSeconds($socialiteUser->expiresIn)
                    : null,
            ]);

            return $user;
        });

        if (!$user->is_active) {
            throw new AuthenticationException('Account has been deactivated');
        }

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);

        $this->logActivity($user, 'google_oauth_login', 'Logged in via Google OAuth');

        return $this->resolveWorkspaceAndIssueTokens($user, $ip, $userAgent);
    }

    /**
     * Verify email address using the verification token.
     *
     * @param string $rawToken
     * @return User
     *
     * @throws AuthenticationException
     */
    public function verifyEmail(string $rawToken): User
    {
        $hashedToken = hash('sha256', $rawToken);

        $user = User::where('email_verification_token', $hashedToken)
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            throw new AuthenticationException('Invalid or expired verification token');
        }

        $user->update([
            'email_verified_at'        => now(),
            'email_verification_token' => null,
        ]);

        $this->logActivity($user, 'email_verified', 'Email address verified');

        return $user;
    }

    /**
     * Change password and invalidate all existing tokens.
     *
     * @param User $user
     * @param string $currentPassword
     * @param string $newPassword
     * @return void
     *
     * @throws AuthenticationException
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new AuthenticationException('Current password is incorrect');
        }

        DB::transaction(function () use ($user, $newPassword) {
            $user->update([
                'password'     => $newPassword,
                'password_set' => true,
            ]);
            $user->incrementTokenVersion();
            $this->issueJwtAction->revokeAllRefreshTokens($user->id);
        });

        $this->logActivity($user, 'password_changed', 'Password changed — all tokens invalidated');
    }

    /**
     * Resume the authentication flow after successful 2FA verification.
     *
     * @param User $user
     * @param string|null $ip
     * @param string|null $userAgent
     * @return array
     */
    public function issueTokensAfter2FA(User $user, ?string $ip = null, ?string $userAgent = null): array
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);

        return $this->resolveWorkspaceAndIssueTokens($user, $ip, $userAgent);
    }

    // ─── Private Helpers ─────────────────────────────────────────

    /**
     * Resolve workspace(s) and issue appropriate tokens.
     *
     * Decision tree:
     * - Platform user → issue platform-guard JWT
     * - 1 corp membership → auto-issue corp-guard JWT
     * - 2+ corp memberships → return workspace selection required
     * - 0 memberships → return no workspace
     */
    private function resolveWorkspaceAndIssueTokens(User $user, ?string $ip, ?string $userAgent): array
    {
        // Check platform membership first
        $platformMembership = PlatformMembership::active()
            ->where('user_id', $user->id)
            ->first();

        if ($platformMembership) {
            $platformRole = $user->roles()
                ->whereNull('model_has_roles.corporation_id')
                ->whereNull('roles.corporation_id')
                ->first();
            $roleName = $platformRole?->name;

            $accessToken = $this->issueJwtAction->issueAccessToken(
                $user, null, AuthGuard::Platform, $roleName
            );
            $refreshToken = $this->issueJwtAction->issueRefreshToken(
                $user, null, AuthGuard::Platform
            );

            $this->logActivity($user, 'login', 'Platform admin login');

            return [
                'status'        => 'authenticated',
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken,
                'token_type'    => 'bearer',
                'expires_in'    => config('jwt.ttl') * 60,
                'guard'         => 'platform',
                'role'          => $roleName,
                'user'          => $user,
            ];
        }

        // Check corp memberships
        $corpMemberships = CorpMembership::active()
            ->where('user_id', $user->id)
            ->with(['corporation:id,uuid,legal_name,trading_name,slug,logo_url'])
            ->get();

        if ($corpMemberships->isEmpty()) {
            return [
                'status'  => 'no_workspace',
                'message' => 'No active workspace found. You may need an invitation to join a corporation.',
                'user'    => $user,
            ];
        }

        if ($corpMemberships->count() === 1) {
            $membership = $corpMemberships->first();
            $corporation = $membership->corporation;
            $role = $user->roles()
                ->where('model_has_roles.corporation_id', $corporation->id)
                ->where('roles.corporation_id', $corporation->id)
                ->first();
            $roleName = $role?->name;

            $accessToken = $this->issueJwtAction->issueAccessToken(
                $user, $corporation, AuthGuard::Corp, $roleName
            );
            $refreshToken = $this->issueJwtAction->issueRefreshToken(
                $user, $corporation, AuthGuard::Corp
            );

            $this->logActivity($user, 'login', "Corp login: {$corporation->legal_name}", $corporation->id);

            return [
                'status'        => 'authenticated',
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken,
                'token_type'    => 'bearer',
                'expires_in'    => config('jwt.ttl') * 60,
                'guard'         => 'corp',
                'role'          => $roleName,
                'corporation'   => $corporation,
                'user'          => $user,
            ];
        }

        // Multiple corp memberships → require workspace selection
        $tempToken = $this->issueJwtAction->issueTempToken($user, 'workspace_selection');

        return [
            'status'                       => 'requires_workspace_selection',
            'message'                      => 'Please select a corporation to continue',
            'requires_workspace_selection'  => true,
            'temp_token'                   => $tempToken,
            'workspaces'                   => $corpMemberships->map(function ($m) use ($user) {
                $role = $user->roles()
                    ->where('model_has_roles.corporation_id', $m->corporation_id)
                    ->where('roles.corporation_id', $m->corporation_id)
                    ->first();
                return [
                    'corporation_uuid' => $m->corporation->uuid,
                    'legal_name'       => $m->corporation->legal_name,
                    'trading_name'     => $m->corporation->trading_name,
                    'slug'             => $m->corporation->slug,
                    'logo_url'         => $m->corporation->logo_url,
                    'role'             => $role?->name,
                ];
            }),
            'user' => $user,
        ];
    }

    /**
     * Log user activity.
     */
    private function logActivity(User $user, string $type, string $description, ?int $corporationId = null): void
    {
        ActivityLog::create([
            'user_id'        => $user->id,
            'corporation_id' => $corporationId,
            'type'           => $type,
            'description'    => $description,
            'ip_address'     => request()->ip(),
            'user_agent'     => substr((string) request()->userAgent(), 0, 500),
        ]);
    }
}
