<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Compliance status of daily attendance.
 */
enum AttendanceComplianceStatusEnum: int
{
    case Compliant = 1;
    case Pending = 2;
    case Overdue = 3;
    case Escalated = 4;
    case PayrollRisk = 5;

    public function label(): string
    {
        return match ($this) {
            self::Compliant => 'Compliant',
            self::Pending => 'Pending',
            self::Overdue => 'Overdue',
            self::Escalated => 'Escalated',
            self::PayrollRisk => 'Payroll Risk',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Compliant => '#10B981', // Green
            self::Pending => '#F59E0B', // Orange
            self::Overdue => '#F97316', // Dark Orange
            self::Escalated => '#EF4444', // Red
            self::PayrollRisk => '#7F1D1D', // Dark Red
        };
    }
}
