<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum AttendanceMode: int
{
    case STRICT   = 1;
    case FLEXIBLE = 2;
    case HYBRID   = 3;

    public function label(): string
    {
        return match($this) {
            self::STRICT   => 'Strict',
            self::FLEXIBLE => 'Flexible',
            self::HYBRID   => 'Hybrid',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::STRICT   => 'Enforces exact shift times. All deviations are penalized.',
            self::FLEXIBLE => 'Tracks total hours only. No shift time enforcement.',
            self::HYBRID   => 'Enforces shift start time only. Exit time is flexible.',
        };
    }
}
