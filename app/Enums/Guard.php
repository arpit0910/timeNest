<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * JWT Guard scopes — defines the authorization context of a token.
 *
 * Platform: internal platform administrators (no organization context).
 * Organization: organization-level users with tenant-scoped access.
 * Temp:     short-lived tokens for 2FA or workspace selection flows.
 */
enum Guard: string
{
    case PLATFORM = 'platform';
    case ORGANIZATION = 'organization';
    case TEMP = 'temp';

    /**
     * Check if this is a platform-level guard.
     */
    public function isPlatform(): bool
    {
        return $this === self::PLATFORM;
    }

    /**
     * Check if this is an organization-level guard.
     */
    public function isOrganization(): bool
    {
        return $this === self::ORGANIZATION;
    }

    /**
     * Check if this is a temporary (intermediate) guard.
     */
    public function isTemp(): bool
    {
        return $this === self::TEMP;
    }

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::PLATFORM => 'Platform',
            self::ORGANIZATION => 'Organization',
            self::TEMP => 'Temporary',
        };
    }
}
