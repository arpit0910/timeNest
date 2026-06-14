<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum AttendanceStatus: int
{
    case Absent     = 1;
    case Present    = 2;
    case HalfDay    = 3;
    case OnLeave    = 4;
    case Holiday    = 5;
    case Weekend    = 6;
    case Incomplete = 7;

    public function label(): string
    {
        return match($this) {
            self::Absent     => 'Absent',
            self::Present    => 'Present',
            self::HalfDay    => 'Half Day',
            self::OnLeave    => 'On Leave',
            self::Holiday    => 'Holiday',
            self::Weekend    => 'Weekend',
            self::Incomplete => 'Incomplete',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Absent     => 'Employee did not clock in and had no approved leave.',
            self::Present    => 'Employee met all required attendance criteria for the day.',
            self::HalfDay    => 'Employee worked only a half-day shift.',
            self::OnLeave    => 'Employee was on approved leave.',
            self::Holiday    => 'Organization defined public holiday.',
            self::Weekend    => 'Organization defined weekend day.',
            self::Incomplete => 'Missing clock out or invalid session data.',
        };
    }
}
