<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum AttendanceMode: int
{
    case Strict   = 1;
    case Flexible = 2;
    case Hybrid   = 3;

    public function label(): string
    {
        return match($this) {
            self::Strict   => 'Strict',
            self::Flexible => 'Flexible',
            self::Hybrid   => 'Hybrid',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Strict   => 'Enforces exact shift times. All deviations are penalized.',
            self::Flexible => 'Tracks total hours only. No shift time enforcement.',
            self::Hybrid   => 'Enforces shift start time only. Exit time is flexible.',
        };
    }
}
