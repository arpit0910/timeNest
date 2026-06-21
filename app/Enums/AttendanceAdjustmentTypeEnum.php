<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Types of attendance corrections.
 */
enum AttendanceAdjustmentTypeEnum: int
{
    case CLOCK_IN_CORRECTION = 1;
    case CLOCK_OUT_CORRECTION = 2;
    case SESSION_DELETION = 3;
    case MANUAL_ATTENDANCE = 4;

    public function label(): string
    {
        return match ($this) {
            self::CLOCK_IN_CORRECTION => 'Clock-In Correction',
            self::CLOCK_OUT_CORRECTION => 'Clock-Out Correction',
            self::SESSION_DELETION => 'Session Deletion',
            self::MANUAL_ATTENDANCE => 'Manual Attendance Entry',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CLOCK_IN_CORRECTION => '#3B82F6', // Blue
            self::CLOCK_OUT_CORRECTION => '#10B981', // Green
            self::SESSION_DELETION => '#EF4444', // Red
            self::MANUAL_ATTENDANCE => '#F59E0B', // Orange
        };
    }
}
