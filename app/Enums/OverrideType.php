<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Permission override types for corporation-level role customization.
 *
 * Allows corporations to grant additional permissions beyond the base role
 * or revoke specific permissions from the base role without modifying the
 * global role definition.
 */
enum OverrideType: string
{
    case Grant = 'grant';
    case Revoke = 'revoke';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Grant => 'Grant',
            self::Revoke => 'Revoke',
        };
    }
}
