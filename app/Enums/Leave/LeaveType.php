<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum LeaveType: int
{
    case Casual = 1;
    case Sick = 2;
    case Paid = 3;
    case Unpaid = 4;
    case WorkFromHome = 5;
    case ExtraWorkingDay = 6;
    case HalfDay = 7;
    case Emergency = 8;
    case Maternity = 9;
    case Paternity = 10;
    case Bereavement = 11;

    public function label(): string
    {
        return match ($this) {
            self::Casual => 'Casual Leave',
            self::Sick => 'Sick Leave',
            self::Paid => 'Paid Leave',
            self::Unpaid => 'Unpaid Leave',
            self::WorkFromHome => 'Work From Home',
            self::ExtraWorkingDay => 'Extra Working Day',
            self::HalfDay => 'Half Day Leave',
            self::Emergency => 'Emergency Leave',
            self::Maternity => 'Maternity Leave',
            self::Paternity => 'Paternity Leave',
            self::Bereavement => 'Bereavement Leave',
        };
    }
}
