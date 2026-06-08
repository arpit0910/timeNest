<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Actions\Auth\SendEmailVerificationAction;
use App\Actions\IssueJwtAction;
use App\Enums\Guard;
use App\Exceptions\Auth\AccountInactiveException;
use App\Exceptions\Auth\EmailNotVerifiedException;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\TwoFactorRequiredException;
use App\Exceptions\Auth\WorkspaceSelectionRequiredException;
use App\Exceptions\Business\InvalidRoleGuardException;
use App\Exceptions\Business\MembershipInactiveException;
use App\Enums\UserStatus;
use App\Models\Auth\OAuthAccount;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Logging\ActivityLog;

use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\PlatformMembership;
use App\Models\Rbac\Role;
use App\Services\Auth\TempTokenService;
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
 * 
 * Throws centralized exceptions for all error conditions:
 * - InvalidCredentialsException (401)
 * - AccountInactiveException (403)
 * - InvalidRoleGuardException (403)
 * - MembershipInactiveException (403)
 */
class AuthService
{
    public function __construct(
        private readonly SendEmailVerificationAction $sendEmailVerificationAction,
        private readonly IssueJwtAction $issueJwtAction,
        private readonly TempTokenService $tempTokenService,
    ) {}

    /**
     * Authenticate a user with email and password.
     *
     * @return array Authentication result with tokens or intermediate state
     *
     * @throws InvalidCredentialsException
     * @throws AccountInactiveException
     */
    public function login(string $email, string $password, ?string $ip = null, ?string $userAgent = null): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! $user->password || ! Hash::check($password, $user->password)) {
            // TODO: Implement failed login tracking and dispatch AccountLockedNotification if threshold exceeded
            throw new InvalidCredentialsException();
        }

        if (! $user->is_active) {
            throw new AccountInactiveException();
        }

        if (! $user->email_verified_at) {
            throw new EmailNotVerifiedException('Please verify your email address');
        }

        // Check 2FA
        if ($user->two_factor_enabled) {
            $tempToken = $this->issueJwtAction->issueTempToken($user, '2fa');

            return [
                'status' => '2fa_required',
                'message' => 'Please complete two-factor authentication to continue.',
                'temp_token' => $tempToken,
                'requires_2fa' => true,
            ];
        }

        // Update login tracking
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ]);

        $user->notify(new \App\Notifications\Auth\NewLoginNotification(
            $user,
            $ip ?? '',
            $userAgent ?? '',
            now()
        ));

        return $this->resolveWorkspaceAndIssueTokens($user, $ip, $userAgent);
    }

    /**
     * Register a new user account.
     *
     * @param  array  $data  Validated registration data
     * @return array Registration result with verification token info
     */
    public function register(array $data): array
    {
        $verificationToken = Str::random(64);

        $user = DB::transaction(function () use ($data, $verificationToken) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'password_set' => true,
                'first_name' => $data['first_name'] ?? null,
                'last_name' => $data['last_name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'timezone' => $data['timezone'] ?? 'UTC',
                'locale' => $data['locale'] ?? 'en',
                'email_verification_token' => hash('sha256', $verificationToken),
                'email_verification_token_expires_at' => now()->addMinutes(
                    (int) config('timenest.verification.expire', 60)
                ),
                'is_active' => false,
                'status' => UserStatus::PendingVerification,
                'token_version' => 1,
            ]);
        });

        // Dispatch verification email AFTER transaction commit
        // so the email is never sent if user creation fails.
        $this->sendEmailVerificationAction->execute($user, $verificationToken);

        $this->logActivity($user, 'registered', 'User account created');

        return [
            'status' => 'registered',
            'message' => 'Registration successful. Please check your email to verify your account.',
            'user' => $user,
        ];
    }

    /**
     * Log out the authenticated user.
     *
     * Invalidates the current JWT and optionally revokes the refresh token.
     *
     * @param  string|null  $refreshToken  Raw refresh token to revoke
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
     * @return array New access + refresh tokens
     *
     * @throws InvalidCredentialsException
     * @throws AccountInactiveException
     * @throws MembershipInactiveException
     * @throws InvalidRoleGuardException
     */
    public function refreshAccessToken(string $rawRefreshToken): array
    {
        $refreshTokenRecord = $this->issueJwtAction->consumeRefreshToken($rawRefreshToken);

        if (! $refreshTokenRecord) {
            throw new InvalidCredentialsException('Invalid or expired refresh token');
        }

        $user = $refreshTokenRecord->user;

        if (! $user || ! $user->is_active) {
            $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);
            throw new AccountInactiveException();
        }

        // Determine guard and organization context from the refresh token
        $guard = Guard::from($refreshTokenRecord->guard);
        $organization = $refreshTokenRecord->organization_id
            ? Organization::find($refreshTokenRecord->organization_id)
            : null;

        // For org guard, verify membership is still active
        if ($guard === Guard::Organization && $organization) {
            $membership = OrganizationMembership::active()
                ->where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->first();

            if (! $membership) {
                $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);
                throw new MembershipInactiveException();
            }

            $roleName = resolve_organization_role($user, $organization->id)?->name;

            if (! $roleName) {
                throw new InvalidRoleGuardException('No role assigned for this organization');
            }
        } elseif ($guard === Guard::Platform) {
            $platformMembership = PlatformMembership::active()
                ->where('user_id', $user->id)
                ->first();

            if (! $platformMembership) {
                $this->issueJwtAction->revokeRefreshToken($rawRefreshToken);
                throw new MembershipInactiveException('Platform access is no longer active');
            }

            $roleName = resolve_platform_role($user)?->name;

            if (! $roleName) {
                throw new InvalidRoleGuardException('No platform role assigned');
            }
        } else {
            $roleName = null;
        }

        $accessToken = $this->issueJwtAction->issueAccessToken($user, $organization, $guard, $roleName);
        $newRefreshToken = $this->issueJwtAction->issueRefreshToken($user, $organization, $guard);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ];
    }

    /**
     * Select an organization workspace and issue org-guard tokens.
     *
     * Used after login when user has multiple org memberships,
     * or to switch between organizations.
     *
     * @param  bool  $switchMode  If true, revoke existing tokens for previous org
     * @param  string|null  $rawTempToken  The raw temporary JWT used for initial selection
     * @return array Tokens and organization info
     *
     * @throws AuthenticationException
     */
    public function selectOrganization(User $user, string $organizationUuid, bool $switchMode = false, ?string $rawTempToken = null): array
    {
        if (!$switchMode && $rawTempToken) {
            $tempTokenRecord = $this->tempTokenService->consume(
                $rawTempToken, 
                'workspace_selection'
            );
            
            // Ensure the user ID matches the token's user ID
            if ($tempTokenRecord->user_id !== $user->id) {
                throw new \App\Exceptions\Auth\InvalidTempTokenException();
            }
        }

        $organization = Organization::where('uuid', $organizationUuid)
            ->active()
            ->firstOrFail();

        $platformRole = resolve_platform_role($user);
        $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

        if (! $isAppOwner) {
            $membership = OrganizationMembership::active()
                ->where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->first();

            if (! $membership) {
                throw new MembershipInactiveException();
            }

            $role = resolve_organization_role($user, $organization->id);

            if (! $role) {
                throw new InvalidRoleGuardException('No role assigned for this organization');
            }

            if ($role->guard_name !== 'api') {
                throw new InvalidRoleGuardException();
            }

            $roleName = $role->name;
        } else {
            $roleName = \App\Enums\SystemRole::AppOwner->value;
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
            $user, $organization, Guard::Organization, $roleName
        );
        $refreshToken = $this->issueJwtAction->issueRefreshToken(
            $user, $organization, Guard::Organization
        );

        $this->logActivity($user, 'organization_selected', "Selected organization: {$organization->legal_name}", $organization->id);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'organization' => $organization,
            'role' => $roleName,
        ];
    }

    /**
     * Get all active workspaces (organizations) for a user.
     */
    public function getWorkspaces(User $user): array
    {
        $orgMemberships = OrganizationMembership::active()
            ->where('user_id', $user->id)
            ->with(['organization:id,uuid,legal_name,trading_name,slug,logo_url'])
            ->get();

        $platformMembership = PlatformMembership::active()
            ->where('user_id', $user->id)
            ->first();

        $platformRole = resolve_platform_role($user);

        return [
            'organizations' => $orgMemberships->map(function ($m) use ($user) {
                $role = resolve_organization_role($user, $m->organization_id);

                return [
                    'organization_uuid' => $m->organization->uuid,
                    'legal_name' => $m->organization->legal_name,
                    'trading_name' => $m->organization->trading_name,
                    'slug' => $m->organization->slug,
                    'logo_url' => $m->organization->logo_url,
                    'role' => $role?->name,
                    'joined_at' => $m->joined_at?->toISOString(),
                ];
            }),
            'has_platform_access' => $platformMembership !== null,
            'platform_role' => $platformRole?->name,
        ];
    }

    /**
     * Handle Google OAuth callback — find or create user, link social account.
     *
     * @return array Authentication result
     */
    public function handleGoogleCallback(SocialiteUser $socialiteUser, ?string $ip = null, ?string $userAgent = null): array
    {
        $user = DB::transaction(function () use ($socialiteUser) {
            // 1. Check oauth_accounts by provider + provider_id
            $oauthAccount = OAuthAccount::where('provider', $provider)
                ->where('provider_id', $socialiteUser->getId())
                ->first();

            if ($oauthAccount) {
                // Update tokens
                $oauthAccount->update([
                    'access_token' => $socialiteUser->token,
                    'refresh_token' => $socialiteUser->refreshToken,
                    'token_expires_at' => $socialiteUser->expiresIn
                        ? now()->addSeconds($socialiteUser->expiresIn)
                        : null,
                    'provider_name' => $socialiteUser->getName(),
                    'provider_avatar' => $socialiteUser->getAvatar(),
                ]);

                return $oauthAccount->user;
            }

            // 2. Check users by email
            $user = User::where('email', $socialiteUser->getEmail())->first();

            if (! $user) {
                // 3. Create new user (OAuth-only, no password)
                $user = User::create([
                    'name' => $socialiteUser->getName() ?? $socialiteUser->getEmail(),
                    'email' => $socialiteUser->getEmail(),
                    'password' => null,
                    'password_set' => false,
                    'email_verified_at' => now(), // Google email is pre-verified
                    'avatar_url' => $socialiteUser->getAvatar(),
                    'is_active' => true,
                    'token_version' => 1,
                ]);
            }

            // Link social account
            OAuthAccount::create([
                'user_id' => $user->id,
                'provider' => 'google',
                'provider_id' => $socialiteUser->getId(),
                'provider_email' => $socialiteUser->getEmail(),
                'provider_name' => $socialiteUser->getName(),
                'provider_avatar' => $socialiteUser->getAvatar(),
                'access_token' => $socialiteUser->token,
                'refresh_token' => $socialiteUser->refreshToken,
                'token_expires_at' => $socialiteUser->expiresIn
                    ? now()->addSeconds($socialiteUser->expiresIn)
                    : null,
            ]);

            return $user;
        });

        if (! $user->is_active) {
            throw new AccountInactiveException();
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
     *
     * @throws AuthenticationException
     */
    public function verifyEmail(string $rawToken): User
    {
        $hashedToken = hash('sha256', $rawToken);

        $user = User::where('email_verification_token', $hashedToken)
            ->whereNull('email_verified_at')
            ->where('email_verification_token_expires_at', '>=', now())
            ->first();

        if (! $user) {
            throw new InvalidCredentialsException('Invalid or expired verification token');
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_token' => null,
            'email_verification_token_expires_at' => null,
            'is_active' => true,
            'status' => UserStatus::Active,
        ]);

        $this->logActivity($user, 'email_verified', 'Email address verified');

        return $user;
    }

    /**
     * Resend email verification to a user.
     *
     * Always returns void regardless of whether the email exists.
     * This prevents user enumeration attacks.
     */
    public function resendVerificationEmail(string $email): void
    {
        $user = User::where('email', $email)
            ->whereNull('email_verified_at')
            ->where('is_active', true)
            ->first();

        if (! $user) {
            // Silently return — do NOT reveal whether the email exists
            return;
        }

        $verificationToken = Str::random(64);

        $user->update([
            'email_verification_token' => hash('sha256', $verificationToken),
            'email_verification_token_expires_at' => now()->addMinutes(
                (int) config('timenest.verification.expire', 60)
            ),
        ]);

        $this->sendEmailVerificationAction->execute($user, $verificationToken);

        $this->logActivity($user, 'verification_email_resent', 'Verification email resent');
    }

    /**
     * Change password and invalidate all existing tokens.
     *
     *
     * @throws AuthenticationException
     */
    public function changePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (! Hash::check($currentPassword, $user->password)) {
            throw new InvalidCredentialsException('Current password is incorrect');
        }

        DB::transaction(function () use ($user, $newPassword) {
            $user->update([
                'password' => $newPassword,
                'password_set' => true,
            ]);
            $user->incrementTokenVersion();
            $this->issueJwtAction->revokeAllRefreshTokens($user->id);
        });

        $user->notify(new \App\Notifications\Auth\PasswordChangedNotification($user));

        $this->logActivity($user, 'password_changed', 'Password changed — all tokens invalidated');
    }

    /**
     * Resume the authentication flow after successful 2FA verification.
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
     * - 1 org membership → auto-issue org-guard JWT
     * - 2+ org memberships → return workspace selection required
     * - 0 memberships → return no workspace
     */
    private function resolveWorkspaceAndIssueTokens(User $user, ?string $ip, ?string $userAgent): array
    {
        // Check platform membership first
        $platformMembership = PlatformMembership::active()
            ->where('user_id', $user->id)
            ->first();

        if ($platformMembership) {
            $platformRole = resolve_platform_role($user);
            $roleName = $platformRole?->name;

            if (! $roleName) {
                throw new InvalidRoleGuardException('No platform role assigned');
            }

            $accessToken = $this->issueJwtAction->issueAccessToken(
                $user, null, Guard::Platform, $roleName
            );
            $refreshToken = $this->issueJwtAction->issueRefreshToken(
                $user, null, Guard::Platform
            );

            $this->logActivity($user, 'login', 'Platform admin login');

            return [
                'status' => 'authenticated',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'guard' => Guard::Platform->value,
                'role' => $roleName,
                'user' => $user,
            ];
        }

        // Check org memberships
        $orgMemberships = OrganizationMembership::active()
            ->where('user_id', $user->id)
            ->with(['organization:id,uuid,legal_name,trading_name,slug,logo_url'])
            ->get();

        if ($orgMemberships->isEmpty()) {
            return [
                'status' => 'no_workspace',
                'message' => 'No active workspace found. You may need an invitation to join an organization.',
                'user' => $user,
            ];
        }

        if ($orgMemberships->count() === 1) {
            $membership = $orgMemberships->first();
            $organization = $membership->organization;
            $role = resolve_organization_role($user, $organization->id);
            $roleName = $role?->name;

            if (! $roleName) {
                throw new InvalidRoleGuardException('No role assigned for this organization');
            }

            $accessToken = $this->issueJwtAction->issueAccessToken(
                $user, $organization, Guard::Organization, $roleName
            );
            $refreshToken = $this->issueJwtAction->issueRefreshToken(
                $user, $organization, Guard::Organization
            );

            $this->logActivity($user, 'login', "Org login: {$organization->legal_name}", $organization->id);

            return [
                'status' => 'authenticated',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'guard' => Guard::Organization->value,
                'role' => $roleName,
                'organization' => $organization,
                'user' => $user,
            ];
        }

        // Multiple org memberships → require workspace selection
        $tempToken = $this->issueJwtAction->issueTempToken($user, 'workspace_selection');

        $workspaces = $orgMemberships->map(function ($m) use ($user) {
            $role = resolve_organization_role($user, $m->organization_id);

            return [
                'organization_uuid' => $m->organization->uuid,
                'legal_name' => $m->organization->legal_name,
                'trading_name' => $m->organization->trading_name,
                'slug' => $m->organization->slug,
                'logo_url' => $m->organization->logo_url,
                'role' => $role?->name,
            ];
        })->toArray();

        throw new WorkspaceSelectionRequiredException('Please select an organization to continue', [
            'requires_workspace_selection' => true,
            'temp_token' => $tempToken,
            'workspaces' => $workspaces,
            'user' => $user,
        ]);
    }

    /**
     * Log user activity.
     */
    private function logActivity(User $user, string $type, string $description, ?int $organizationId = null): void
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'organization_id' => $organizationId,
            'type' => $type,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
        ]);
    }

}
