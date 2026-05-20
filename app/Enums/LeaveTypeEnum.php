<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Leave types. Note that WFH and EWD are handled as leave types.
 */
enum LeaveTypeEnum: int
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

    public function color(): string
    {
        return match ($this) {
            self::Casual => '#60A5FA', // Light Blue
            self::Sick => '#F87171', // Light Red
            self::Paid => '#34D399', // Light Green
            self::Unpaid => '#9CA3AF', // Gray
            self::WorkFromHome => '#A78BFA', // Purple
            self::ExtraWorkingDay => '#FBBF24', // Amber
            self::HalfDay => '#F472B6', // Pink
            self::Emergency => '#EF4444', // Red
            self::Maternity => '#EC4899', // Pink
            self::Paternity => '#3B82F6', // Blue
            self::Bereavement => '#4B5563', // Dark Gray
        };
    }

    public function isWFH(): bool
    {
        return $this === self::WorkFromHome;
    }

    public function isEWD(): bool
    {
        return $this === self::ExtraWorkingDay;
    }
}
