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
    case Active = 1;
    case Inactive = 2;
    case Suspended = 3;
    case PendingVerification = 4;

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Suspended => 'Suspended',
            self::PendingVerification => 'Pending Verification',
        };
    }

    /**
     * Determine if account is in an accessible state.
     */
    public function isAccessible(): bool
    {
        return $this === self::Active;
    }
}
