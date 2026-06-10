<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Modes of worklog enforcement.
 */
enum WorklogModeEnum: int
{
    case Strict = 1;
    case Flexible = 2;
    case Hybrid = 3;

    public function label(): string
    {
        return match ($this) {
            self::Strict => 'Strict',
            self::Flexible => 'Flexible',
            self::Hybrid => 'Hybrid',
        };
    }
}
