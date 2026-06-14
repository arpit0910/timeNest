<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum WorklogComplianceStatus: int
{
    case Compliant = 1;
    case Overdue   = 2;
    case Locked    = 3;
    case Escalated = 4;

    public function label(): string
    {
        return match($this) {
            self::Compliant => 'Compliant',
            self::Overdue   => 'Overdue',
            self::Locked    => 'Locked',
            self::Escalated => 'Escalated',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Compliant => 'Worklog submitted within the allowed timeframe.',
            self::Overdue   => 'Worklog not submitted by the deadline.',
            self::Locked    => 'Worklog submission window closed and locked.',
            self::Escalated => 'Overdue worklog has been escalated to management.',
        };
    }
}
