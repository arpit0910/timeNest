<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Permission override types for organization-level role customization.
 *
 * Allows organizations to grant additional permissions beyond the base role
 * or revoke specific permissions from the base role without modifying the
 * global role definition.
 */
enum OverrideType: string
{
    case GRANT = 'grant';
    case REVOKE = 'revoke';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::GRANT => 'Grant',
            self::REVOKE => 'Revoke',
        };
    }
}
