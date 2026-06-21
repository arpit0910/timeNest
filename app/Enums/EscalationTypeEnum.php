<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Triggers/Types of attendance escalations.
 */
enum EscalationTypeEnum: int
{
    case OVERDUE_WORKLOG = 1;
    case LOW_PRODUCTIVITY = 2;
    case MISSING_LOG = 3;
    case EXCESSIVE_OVERFLOW = 4;
    case REPEATED_REJECTION = 5;
    case COMPLIANCE_VIOLATION = 6;

    public function label(): string
    {
        return match ($this) {
            self::OVERDUE_WORKLOG => 'Overdue Worklog Submission',
            self::LOW_PRODUCTIVITY => 'Repeated Low Productivity',
            self::MISSING_LOG => 'Missing Worklog',
            self::EXCESSIVE_OVERFLOW => 'Excessive Task Estimate Overflow',
            self::REPEATED_REJECTION => 'Repeated Worklog Rejections',
            self::COMPLIANCE_VIOLATION => 'Compliance Violation',
        };
    }
}
