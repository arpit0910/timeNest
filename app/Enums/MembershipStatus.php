<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Organization membership lifecycle states.
 *
 * Tracks the relationship between a user and an organization
 * from invitation acceptance through active membership to separation.
 */
enum MembershipStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Revoked = 'revoked';
    case Suspended = 'suspended';
    case Left = 'left';

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Active => 'Active',
            self::Revoked => 'Revoked',
            self::Suspended => 'Suspended',
            self::Left => 'Left',
        };
    }

    /**
     * Determine if membership is in an accessible state.
     */
    public function isAccessible(): bool
    {
        return $this === self::Active;
    }
}
