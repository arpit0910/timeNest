<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Statuses of a daily attendance record.
 */
enum AttendanceStatusEnum: int
{
    case Absent = 1;
    case Present = 2;
    case HalfDay = 3;
    case Leave = 4;
    case Holiday = 5;
    case Weekend = 6;
    case Incomplete = 7;

    public function label(): string
    {
        return match ($this) {
            self::Absent => 'Absent',
            self::Present => 'Present',
            self::HalfDay => 'Half Day',
            self::Leave => 'Leave',
            self::Holiday => 'Holiday',
            self::Weekend => 'Weekend',
            self::Incomplete => 'Incomplete',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Absent => '#EF4444', // Red
            self::Present => '#10B981', // Green
            self::HalfDay => '#F59E0B', // Orange
            self::Leave => '#3B82F6', // Blue
            self::Holiday => '#8B5CF6', // Purple
            self::Weekend => '#6B7280', // Gray
            self::Incomplete => '#EC4899', // Pink
        };
    }

    public function isWorked(): bool
    {
        return in_array($this, [self::Present, self::HalfDay, self::Incomplete], true);
    }
}
