<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Compliance status for attendance worklogs.
 */
enum WorklogComplianceStatusEnum: int
{
    case Compliant = 1;
    case Overflow = 2;
    case Overdue = 3;
    case LowProductivity = 4;

    public function label(): string
    {
        return match ($this) {
            self::Compliant => 'Compliant',
            self::Overflow => 'Estimate Overflow',
            self::Overdue => 'Overdue',
            self::LowProductivity => 'Low Productivity',
        };
    }
}
