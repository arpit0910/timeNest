<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\AuthGuard;
use App\Models\Auth\RefreshToken;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * Issues JWT access tokens and refresh tokens.
 *
 * Access tokens carry custom claims: guard, corporation context, role, and token_version.
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
     * @param User $user
     * @param Corporation|null $corporation
     * @param AuthGuard $guard
     * @param string|null $roleName
     * @return string The JWT access token string
     */
    public function issueAccessToken(
        User $user,
        ?Corporation $corporation,
        AuthGuard $guard,
        ?string $roleName = null,
    ): string {
        $customClaims = [
            'user_uuid'        => $user->uuid,
            'guard'            => $guard->value,
            'corporation_id'   => $corporation?->id,
            'corporation_uuid' => $corporation?->uuid,
            'role'             => $roleName,
            'token_version'    => $user->token_version,
        ];

        return JWTAuth::claims($customClaims)->fromUser($user);
    }

    /**
     * Issue a temporary JWT (short-lived) for 2FA or workspace selection.
     *
     * TTL: 5 minutes. Used as an intermediate token before full authentication.
     *
     * @param User $user
     * @param string $purpose '2fa' or 'workspace_selection'
     * @return string
     */
    public function issueTempToken(User $user, string $purpose): string
    {
        $customClaims = [
            'user_uuid'     => $user->uuid,
            'guard'         => 'temp',
            'purpose'       => $purpose,
            'token_version' => $user->token_version,
        ];

        // Override TTL for temp token: 5 minutes
        $factory = JWTAuth::factory();
        $originalTtl = $factory->getTTL();
        $factory->setTTL(5);

        $token = JWTAuth::claims($customClaims)->fromUser($user);

        // Restore original TTL
        $factory->setTTL($originalTtl);

        return $token;
    }

    /**
     * Issue a refresh token and store its SHA-256 hash in the database.
     *
     * The raw token is returned to the client ONCE. Only the hash is stored.
     *
     * @param User $user
     * @param Corporation|null $corporation
     * @param AuthGuard $guard
     * @return string The raw refresh token (send to client, never store raw)
     */
    public function issueRefreshToken(
        User $user,
        ?Corporation $corporation,
        AuthGuard $guard,
    ): string {
        $rawToken = Str::random(80);
        $tokenHash = hash('sha256', $rawToken);

        RefreshToken::create([
            'user_id'        => $user->id,
            'token_hash'     => $tokenHash,
            'guard'          => $guard->value,
            'corporation_id' => $corporation?->id,
            'ip_address'     => request()->ip(),
            'user_agent'     => substr((string) request()->userAgent(), 0, 500),
            'expires_at'     => now()->addDays(30),
        ]);

        return $rawToken;
    }

    /**
     * Revoke a refresh token by its raw value.
     *
     * @param string $rawToken
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
     * @param int $userId
     * @return int Number of tokens revoked
     */
    public function revokeAllRefreshTokens(int $userId): int
    {
        return RefreshToken::where('user_id', $userId)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    /**
     * Revoke all refresh tokens for a user in a specific corporation.
     *
     * Used when membership is revoked or suspended.
     *
     * @param int $userId
     * @param int $corporationId
     * @return int Number of tokens revoked
     */
    public function revokeCorpRefreshTokens(int $userId, int $corporationId): int
    {
        return RefreshToken::where('user_id', $userId)
            ->where('corporation_id', $corporationId)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    /**
     * Validate a raw refresh token and return the record if valid.
     *
     * @param string $rawToken
     * @return RefreshToken|null
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
}
