<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\AuthGuard;
use App\Models\Auth\RefreshToken;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTFactory;

/**
 * JWT token issuance, refresh, and revocation.
 *
 * Handles:
 * - Access token issuance with custom claims (guard, corporation, role, token_version)
 * - Refresh token generation and hashed storage
 * - Token revocation and version validation
 */
trait InteractsWithJwt
{
    /**
     * Issue a JWT access token with custom claims.
     *
     * @param User $user
     * @param Corporation|null $corp
     * @param AuthGuard $guard
     * @param string|null $roleName
     * @return string
     */
    protected function issueAccessToken(
        User $user,
        ?Corporation $corp,
        AuthGuard $guard,
        ?string $roleName = null,
    ): string {
        $customClaims = [
            'user_uuid'        => $user->uuid,
            'guard'            => $guard->value,
            'corporation_id'   => $corp?->id,
            'corporation_uuid' => $corp?->uuid,
            'role'             => $roleName,
            'token_version'    => $user->token_version,
        ];

        return JWTAuth::claims($customClaims)->fromUser($user);
    }

    /**
     * Issue a refresh token and store its hash in the database.
     *
     * @param User $user
     * @param Corporation|null $corp
     * @param AuthGuard $guard
     * @return string The raw refresh token (returned to client once, never stored raw)
     */
    protected function issueRefreshToken(
        User $user,
        ?Corporation $corp,
        AuthGuard $guard,
    ): string {
        $rawToken = Str::random(64);
        $tokenHash = hash('sha256', $rawToken);

        RefreshToken::create([
            'user_id'        => $user->id,
            'token_hash'     => $tokenHash,
            'guard'          => $guard->value,
            'corporation_id' => $corp?->id,
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'expires_at'     => now()->addDays(30),
        ]);

        return $rawToken;
    }

    /**
     * Revoke a refresh token by its raw value.
     *
     * @param string $rawToken
     * @return bool
     */
    protected function revokeRefreshToken(string $rawToken): bool
    {
        $tokenHash = hash('sha256', $rawToken);

        return (bool) RefreshToken::where('token_hash', $tokenHash)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    /**
     * Validate that the JWT's token_version matches the user's current version.
     *
     * A mismatch means the user changed their password or was force-logged-out,
     * and all previously issued tokens are invalid.
     *
     * @param int $claimedVersion
     * @param User $user
     * @return bool
     */
    protected function validateTokenVersion(int $claimedVersion, User $user): bool
    {
        return $claimedVersion === $user->token_version;
    }
}
