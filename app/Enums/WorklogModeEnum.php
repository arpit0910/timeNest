<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Modes of worklog enforcement.
 */
enum WorklogModeEnum: int
{
    case STRICT = 1;
    case FLEXIBLE = 2;
    case HYBRID = 3;

    public function label(): string
    {
        return match ($this) {
            self::STRICT => 'Strict',
            self::FLEXIBLE => 'Flexible',
            self::HYBRID => 'Hybrid',
        };
    }
}
