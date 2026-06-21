<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum WorklogComplianceStatus: int
{
    case COMPLIANT = 1;
    case OVERDUE   = 2;
    case LOCKED    = 3;
    case ESCALATED = 4;

    public function label(): string
    {
        return match($this) {
            self::COMPLIANT => 'Compliant',
            self::OVERDUE   => 'Overdue',
            self::LOCKED    => 'Locked',
            self::ESCALATED => 'Escalated',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::COMPLIANT => 'Worklog submitted within the allowed timeframe.',
            self::OVERDUE   => 'Worklog not submitted by the deadline.',
            self::LOCKED    => 'Worklog submission window closed and locked.',
            self::ESCALATED => 'Overdue worklog has been escalated to management.',
        };
    }
}
