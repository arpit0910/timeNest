<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * User account lifecycle states.
 *
 * Tracks the overall account state from registration through
 * verification to active usage or administrative suspension.
 */
enum UserStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case SUSPENDED = 3;
    case PENDING_VERIFICATION = 4;

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::SUSPENDED => 'Suspended',
            self::PENDING_VERIFICATION => 'Pending Verification',
        };
    }

    /**
     * Determine if account is in an accessible state.
     */
    public function isAccessible(): bool
    {
        return $this === self::ACTIVE;
    }
}
