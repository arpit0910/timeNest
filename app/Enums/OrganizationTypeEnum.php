<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Types of organizations.
 */
enum OrganizationTypeEnum: int
{
    case Personal = 1;
    case Team = 2;
    case Organization = 3;

    public function label(): string
    {
        return match ($this) {
            self::Personal => 'Personal',
            self::Team => 'Team',
            self::Organization => 'Organization',
        };
    }
}
