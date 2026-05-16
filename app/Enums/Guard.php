<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * JWT Guard scopes — defines the authorization context of a token.
 *
 * Platform: internal platform administrators (no corporation context).
 * Corp:     corporation-level users with tenant-scoped access.
 * Temp:     short-lived tokens for 2FA or workspace selection flows.
 */
enum Guard: string
{
    case Platform = 'platform';
    case Corp     = 'corp';
    case Temp     = 'temp';

    /**
     * Check if this is a platform-level guard.
     */
    public function isPlatform(): bool
    {
        return $this === self::Platform;
    }

    /**
     * Check if this is a corporation-level guard.
     */
    public function isCorp(): bool
    {
        return $this === self::Corp;
    }

    /**
     * Check if this is a temporary (intermediate) guard.
     */
    public function isTemp(): bool
    {
        return $this === self::Temp;
    }

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Platform => 'Platform',
            self::Corp     => 'Corporation',
            self::Temp     => 'Temporary',
        };
    }
}
