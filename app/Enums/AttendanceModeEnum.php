<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Modes of attendance enforcement.
 */
enum AttendanceModeEnum: int
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

    public function color(): string
    {
        return match ($this) {
            self::STRICT => '#EF4444', // Red
            self::FLEXIBLE => '#10B981', // Green
            self::HYBRID => '#3B82F6', // Blue
        };
    }

    public function isStrict(): bool
    {
        return $this === self::STRICT;
    }

    public function isFlexible(): bool
    {
        return $this === self::FLEXIBLE;
    }

    public function isHybrid(): bool
    {
        return $this === self::HYBRID;
    }
}
