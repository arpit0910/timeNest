<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Statuses of a daily attendance record.
 */
enum AttendanceStatusEnum: int
{
    case ABSENT = 1;
    case PRESENT = 2;
    case HALF_DAY = 3;
    case LEAVE = 4;
    case HOLIDAY = 5;
    case WEEKEND = 6;
    case INCOMPLETE = 7;

    public function label(): string
    {
        return match ($this) {
            self::ABSENT => 'Absent',
            self::PRESENT => 'Present',
            self::HALF_DAY => 'Half Day',
            self::LEAVE => 'Leave',
            self::HOLIDAY => 'Holiday',
            self::WEEKEND => 'Weekend',
            self::INCOMPLETE => 'Incomplete',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ABSENT => '#EF4444', // Red
            self::PRESENT => '#10B981', // Green
            self::HALF_DAY => '#F59E0B', // Orange
            self::LEAVE => '#3B82F6', // Blue
            self::HOLIDAY => '#8B5CF6', // Purple
            self::WEEKEND => '#6B7280', // Gray
            self::INCOMPLETE => '#EC4899', // Pink
        };
    }

    public function isWorked(): bool
    {
        return in_array($this, [self::PRESENT, self::HALF_DAY, self::INCOMPLETE], true);
    }
}
