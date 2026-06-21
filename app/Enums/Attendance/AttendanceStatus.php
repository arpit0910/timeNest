<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum AttendanceStatus: int
{
    case ABSENT     = 1;
    case PRESENT    = 2;
    case HALF_DAY    = 3;
    case ON_LEAVE    = 4;
    case HOLIDAY    = 5;
    case WEEKEND    = 6;
    case INCOMPLETE = 7;

    public function label(): string
    {
        return match($this) {
            self::ABSENT     => 'Absent',
            self::PRESENT    => 'Present',
            self::HALF_DAY    => 'Half Day',
            self::ON_LEAVE    => 'On Leave',
            self::HOLIDAY    => 'Holiday',
            self::WEEKEND    => 'Weekend',
            self::INCOMPLETE => 'Incomplete',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::ABSENT     => 'Employee did not clock in and had no approved leave.',
            self::PRESENT    => 'Employee met all required attendance criteria for the day.',
            self::HALF_DAY    => 'Employee worked only a half-day shift.',
            self::ON_LEAVE    => 'Employee was on approved leave.',
            self::HOLIDAY    => 'Organization defined public holiday.',
            self::WEEKEND    => 'Organization defined weekend day.',
            self::INCOMPLETE => 'Missing clock out or invalid session data.',
        };
    }
}
