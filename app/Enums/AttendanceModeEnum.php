<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Modes of attendance enforcement.
 */
enum AttendanceModeEnum: int
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

    public function color(): string
    {
        return match ($this) {
            self::Strict => '#EF4444', // Red
            self::Flexible => '#10B981', // Green
            self::Hybrid => '#3B82F6', // Blue
        };
    }

    public function isStrict(): bool
    {
        return $this === self::Strict;
    }

    public function isFlexible(): bool
    {
        return $this === self::Flexible;
    }

    public function isHybrid(): bool
    {
        return $this === self::Hybrid;
    }
}
