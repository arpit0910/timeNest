<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum ComplianceStatus: int
{
    case Compliant   = 1;
    case Pending     = 2;
    case Overdue     = 3;
    case Escalated   = 4;
    case PayrollRisk = 5;

    public function label(): string
    {
        return match($this) {
            self::Compliant   => 'Compliant',
            self::Pending     => 'Pending',
            self::Overdue     => 'Overdue',
            self::Escalated   => 'Escalated',
            self::PayrollRisk => 'Payroll Risk',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Compliant   => 'No violations, fully compliant with policy.',
            self::Pending     => 'Awaiting review or worklog submission.',
            self::Overdue     => 'Past the permitted time window for correction.',
            self::Escalated   => 'Requires manager or HR intervention.',
            self::PayrollRisk => 'Severe violation that will impact payroll deductions.',
        };
    }
}
