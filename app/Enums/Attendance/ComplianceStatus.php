<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum ComplianceStatus: int
{
    case COMPLIANT   = 1;
    case PENDING     = 2;
    case OVERDUE     = 3;
    case ESCALATED   = 4;
    case PAYROLL_RISK = 5;

    public function label(): string
    {
        return match($this) {
            self::COMPLIANT   => 'Compliant',
            self::PENDING     => 'Pending',
            self::OVERDUE     => 'Overdue',
            self::ESCALATED   => 'Escalated',
            self::PAYROLL_RISK => 'Payroll Risk',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::COMPLIANT   => 'No violations, fully compliant with policy.',
            self::PENDING     => 'Awaiting review or worklog submission.',
            self::OVERDUE     => 'Past the permitted time window for correction.',
            self::ESCALATED   => 'Requires manager or HR intervention.',
            self::PAYROLL_RISK => 'Severe violation that will impact payroll deductions.',
        };
    }
}
