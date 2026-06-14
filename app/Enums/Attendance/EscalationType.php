<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum EscalationType: int
{
    case MissingWorklog       = 1;
    case LateArrival          = 2;
    case EarlyExit            = 3;
    case UnapprovedOvertime   = 4;
    case AttendanceCorrection = 5;

    public function label(): string
    {
        return match($this) {
            self::MissingWorklog       => 'Missing Worklog',
            self::LateArrival          => 'Late Arrival',
            self::EarlyExit            => 'Early Exit',
            self::UnapprovedOvertime   => 'Unapproved Overtime',
            self::AttendanceCorrection => 'Attendance Correction',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::MissingWorklog       => 'Employee failed to submit a worklog on time.',
            self::LateArrival          => 'Employee arrived later than the allowed grace period.',
            self::EarlyExit            => 'Employee exited earlier than the allowed grace period.',
            self::UnapprovedOvertime   => 'Employee recorded overtime without prior approval.',
            self::AttendanceCorrection => 'A manual correction to attendance requires review.',
        };
    }
}
