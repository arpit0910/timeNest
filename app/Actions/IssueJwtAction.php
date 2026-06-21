<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\Guard;
use App\Models\Auth\RefreshToken;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * Issues JWT access tokens and refresh tokens.
 *
 * Access tokens carry custom claims: guard, organization context, role, and token_version.
 * Refresh tokens are stored hashed (SHA-256) in the database for revocation support.
 *
 * This is a single-purpose Action class — called by AuthService and other services
 * that need to issue tokens (e.g., InvitationService on acceptance).
 */
class IssueJwtAction
{
    /**
     * Issue a JWT access token with custom claims.
     *
     * @return string The JWT access token string
     */
    public function issueAccessToken(
        User $user,
        ?Organization $organization,
        Guard $guard,
        ?string $roleName = null,
    ): string {
        $tokenVersion = $user->token_version ?? $user->fresh()->token_version ?? 1;

        $customClaims = [
            'user_uuid' => $user->uuid,
            'guard' => $guard->value,
            'organization_uuid' => $organization?->uuid,
            'role' => $roleName,
            'token_version' => $tokenVersion,
        ];

        return JWTAuth::claims($customClaims)->fromUser($user);
    }

    /**
     * Issue a temporary JWT (short-lived) for 2FA or workspace selection.
     *
     * TTL: Configured via temp_token_ttl (default 10 minutes). Used as an intermediate token before full authentication.
     *
     * @param  string  $purpose  '2fa' or 'workspace_selection'
     */
    public function issueTempToken(User $user, string $purpose): string
    {
        $tokenVersion = $user->token_version ?? $user->fresh()->token_version ?? 1;
        $jti = (string) Str::uuid();

        $customClaims = [
            'user_uuid' => $user->uuid,
            'guard' => Guard::TEMP->value,
            'purpose' => $purpose,
            'token_version' => $tokenVersion,
            'jti' => $jti,
        ];

        $ttlMinutes = config('timenest.temp_token_ttl', 10);

        // Override TTL for temp token
        $factory = JWTAuth::factory();
        $originalTtl = $factory->getTTL();
        $factory->setTTL($ttlMinutes);

        $token = JWTAuth::claims($customClaims)->fromUser($user);

        // Restore original TTL
        $factory->setTTL($originalTtl);

        \App\Models\Auth\TempToken::create([
            'jti' => $jti,
            'user_id' => $user->id,
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes($ttlMinutes),
        ]);

        return $token;
    }

    /**
     * Issue a refresh token and store its SHA-256 hash in the database.
     *
     * The raw token is returned to the client ONCE. Only the hash is stored.
     *
     * @return string The raw refresh token (send to client, never store raw)
     */
    public function issueRefreshToken(
        User $user,
        ?Organization $organization,
        Guard $guard,
    ): string {
        $rawToken = Str::random(80);
        $tokenHash = hash('sha256', $rawToken);

        RefreshToken::create([
            'user_id' => $user->id,
            'token_hash' => $tokenHash,
            'guard' => $guard->value,
            'organization_id' => $organization?->id,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 500),
            'expires_at' => now()->addDays(30),
        ]);

        return $rawToken;
    }

    /**
     * Revoke a refresh token by its raw value.
     *
     * @return bool Whether a token was found and revoked
     */
    public function revokeRefreshToken(string $rawToken): bool
    {
        $tokenHash = hash('sha256', $rawToken);

        $affected = RefreshToken::where('token_hash', $tokenHash)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);

        return $affected > 0;
    }

    /**
     * Revoke all refresh tokens for a user.
     *
     * Used on password change, forced logout, or account deactivation.
     *
     * @return int Number of tokens revoked
     */
    public function revokeAllRefreshTokens(int $userId): int
    {
        return RefreshToken::where('user_id', $userId)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    /**
     * Revoke all refresh tokens for a user in a specific organization.
     *
     * Used when membership is revoked or suspended.
     *
     * @return int Number of tokens revoked
     */
    public function revokeOrganizationRefreshTokens(int $userId, int $organizationId): int
    {
        return RefreshToken::where('user_id', $userId)
            ->where('organization_id', $organizationId)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    /**
     * Validate a raw refresh token and return the record if valid.
     */
    public function validateRefreshToken(string $rawToken): ?RefreshToken
    {
        $tokenHash = hash('sha256', $rawToken);

        return RefreshToken::where('token_hash', $tokenHash)
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->with('user')
            ->first();
    }

    public function consumeRefreshToken(string $rawToken): ?RefreshToken
    {
        $tokenHash = hash('sha256', $rawToken);

        return DB::transaction(function () use ($tokenHash): ?RefreshToken {
            $refreshToken = RefreshToken::where('token_hash', $tokenHash)
                ->whereNull('revoked_at')
                ->where('expires_at', '>', now())
                ->with('user')
                ->lockForUpdate()
                ->first();

            if (! $refreshToken) {
                return null;
            }

            $refreshToken->forceFill(['revoked_at' => now()])->save();

            return $refreshToken;
        });
    }
}
