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
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REVOKED = 'revoked';
    case SUSPENDED = 'suspended';
    case LEFT = 'left';

    /**
     * Get human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::REVOKED => 'Revoked',
            self::SUSPENDED => 'Suspended',
            self::LEFT => 'Left',
        };
    }

    /**
     * Determine if membership is in an accessible state.
     */
    public function isAccessible(): bool
    {
        return $this === self::ACTIVE;
    }
}
