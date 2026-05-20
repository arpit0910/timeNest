<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Triggers/Types of attendance escalations.
 */
enum EscalationTypeEnum: int
{
    case OverdueWorklog = 1;
    case LowProductivity = 2;
    case MissingLog = 3;
    case ExcessiveOverflow = 4;
    case RepeatedRejection = 5;
    case ComplianceViolation = 6;

    public function label(): string
    {
        return match ($this) {
            self::OverdueWorklog => 'Overdue Worklog Submission',
            self::LowProductivity => 'Repeated Low Productivity',
            self::MissingLog => 'Missing Worklog',
            self::ExcessiveOverflow => 'Excessive Task Estimate Overflow',
            self::RepeatedRejection => 'Repeated Worklog Rejections',
            self::ComplianceViolation => 'Compliance Violation',
        };
    }
}
