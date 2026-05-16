<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Authentication guard scopes.
 *
 * Platform guard: internal platform administrators.
 * Corp guard: corporation-level users with corporation-scoped access.
 */
enum AuthGuard: string
{
    case Platform = 'platform';
    case Corp     = 'corp';

    /**
     * Get human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::Platform => 'Platform',
            self::Corp     => 'Corporation',
        };
    }
}
