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

    public function label(): string
    {
        return match ($this) {
            self::Casual => 'Casual Leave',
            self::Sick => 'Sick Leave',
            self::Paid => 'Paid Leave',
            self::Unpaid => 'Unpaid Leave',
            self::WorkFromHome => 'Work From Home',
            self::ExtraWorkingDay => 'Extra Working Day',
        };
    }
}
