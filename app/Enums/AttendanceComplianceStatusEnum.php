<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Compliance status of daily attendance.
 */
enum AttendanceComplianceStatusEnum: int
{
    case COMPLIANT = 1;
    case PENDING = 2;
    case OVERDUE = 3;
    case ESCALATED = 4;
    case PAYROLL_RISK = 5;

    public function label(): string
    {
        return match ($this) {
            self::COMPLIANT => 'Compliant',
            self::PENDING => 'Pending',
            self::OVERDUE => 'Overdue',
            self::ESCALATED => 'Escalated',
            self::PAYROLL_RISK => 'Payroll Risk',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::COMPLIANT => '#10B981', // Green
            self::PENDING => '#F59E0B', // Orange
            self::OVERDUE => '#F97316', // Dark Orange
            self::ESCALATED => '#EF4444', // Red
            self::PAYROLL_RISK => '#7F1D1D', // Dark Red
        };
    }
}
