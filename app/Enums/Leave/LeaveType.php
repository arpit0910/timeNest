<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum LeaveType: int
{
    case CASUAL = 1;
    case SICK = 2;
    case PAID = 3;
    case UNPAID = 4;
    case WORK_FROM_HOME = 5;
    case EXTRA_WORKING_DAY = 6;
    case HALF_DAY = 7;
    case EMERGENCY = 8;
    case MATERNITY = 9;
    case PATERNITY = 10;
    case BEREAVEMENT = 11;

    public function label(): string
    {
        return match ($this) {
            self::CASUAL => 'Casual Leave',
            self::SICK => 'Sick Leave',
            self::PAID => 'Paid Leave',
            self::UNPAID => 'Unpaid Leave',
            self::WORK_FROM_HOME => 'Work From Home',
            self::EXTRA_WORKING_DAY => 'Extra Working Day',
            self::HALF_DAY => 'Half Day Leave',
            self::EMERGENCY => 'Emergency Leave',
            self::MATERNITY => 'Maternity Leave',
            self::PATERNITY => 'Paternity Leave',
            self::BEREAVEMENT => 'Bereavement Leave',
        };
    }
}
