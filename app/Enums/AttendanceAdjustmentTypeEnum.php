<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Types of attendance corrections.
 */
enum AttendanceAdjustmentTypeEnum: int
{
    case ClockInCorrection = 1;
    case ClockOutCorrection = 2;
    case SessionDeletion = 3;
    case ManualAttendance = 4;

    public function label(): string
    {
        return match ($this) {
            self::ClockInCorrection => 'Clock-In Correction',
            self::ClockOutCorrection => 'Clock-Out Correction',
            self::SessionDeletion => 'Session Deletion',
            self::ManualAttendance => 'Manual Attendance Entry',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ClockInCorrection => '#3B82F6', // Blue
            self::ClockOutCorrection => '#10B981', // Green
            self::SessionDeletion => '#EF4444', // Red
            self::ManualAttendance => '#F59E0B', // Orange
        };
    }
}
