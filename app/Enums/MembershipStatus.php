<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Corporation membership lifecycle states.
 *
 * Tracks the relationship between a user and a corporation
 * from invitation acceptance through active membership to separation.
 */
enum MembershipStatus: string
{
    case Pending   = 'pending';
    case Active    = 'active';
    case Revoked   = 'revoked';
    case Suspended = 'suspended';
    case Left      = 'left';

    /**
     * Get human-readable label for the status.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending   => 'Pending',
            self::Active    => 'Active',
            self::Revoked   => 'Revoked',
            self::Suspended => 'Suspended',
            self::Left      => 'Left',
        };
    }

    /**
     * Determine if membership is in an accessible state.
     *
     * @return bool
     */
    public function isAccessible(): bool
    {
        return $this === self::Active;
    }
}
