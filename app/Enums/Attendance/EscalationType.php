<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum EscalationType: int
{
    case MISSING_WORKLOG       = 1;
    case LATE_ARRIVAL          = 2;
    case EARLY_EXIT            = 3;
    case UNAPPROVED_OVERTIME   = 4;
    case ATTENDANCE_CORRECTION = 5;

    public function label(): string
    {
        return match($this) {
            self::MISSING_WORKLOG       => 'Missing Worklog',
            self::LATE_ARRIVAL          => 'Late Arrival',
            self::EARLY_EXIT            => 'Early Exit',
            self::UNAPPROVED_OVERTIME   => 'Unapproved Overtime',
            self::ATTENDANCE_CORRECTION => 'Attendance Correction',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::MISSING_WORKLOG       => 'Employee failed to submit a worklog on time.',
            self::LATE_ARRIVAL          => 'Employee arrived later than the allowed grace period.',
            self::EARLY_EXIT            => 'Employee exited earlier than the allowed grace period.',
            self::UNAPPROVED_OVERTIME   => 'Employee recorded overtime without prior approval.',
            self::ATTENDANCE_CORRECTION => 'A manual correction to attendance requires review.',
        };
    }
}
