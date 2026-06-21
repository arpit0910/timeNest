<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Compliance status for attendance worklogs.
 */
enum WorklogComplianceStatusEnum: int
{
    case COMPLIANT = 1;
    case OVERFLOW = 2;
    case OVERDUE = 3;
    case LOW_PRODUCTIVITY = 4;

    public function label(): string
    {
        return match ($this) {
            self::COMPLIANT => 'Compliant',
            self::OVERFLOW => 'Estimate Overflow',
            self::OVERDUE => 'Overdue',
            self::LOW_PRODUCTIVITY => 'Low Productivity',
        };
    }
}
