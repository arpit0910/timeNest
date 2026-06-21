<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Types of organizations.
 */
enum OrganizationTypeEnum: int
{
    case PERSONAL = 1;
    case TEAM = 2;
    case ORGANIZATION = 3;

    public function label(): string
    {
        return match ($this) {
            self::PERSONAL => 'Personal',
            self::TEAM => 'Team',
            self::ORGANIZATION => 'Organization',
        };
    }
}
