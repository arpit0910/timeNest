<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Centralized Workflow Status Enum for system-wide state transitions.
 */
enum WorkflowStatusEnum: int
{
    case Draft = 1;
    case Pending = 2;
    case Submitted = 3;
    case Approved = 4;
    case Rejected = 5;
    case Cancelled = 6;
    case Escalated = 7;
    case OnHold = 8;
    case RevisionRequested = 9;
    case PayrollBlocked = 10;
    case ComplianceReview = 11;
    case Locked = 12;
    case Overdue = 13;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Submitted => 'Submitted',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
            self::Escalated => 'Escalated',
            self::OnHold => 'On Hold',
            self::RevisionRequested => 'Revision Requested',
            self::PayrollBlocked => 'Payroll Blocked',
            self::ComplianceReview => 'Compliance Review',
            self::Locked => 'Locked',
            self::Overdue => 'Overdue',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => '#6B7280', // Gray
            self::Pending => '#F59E0B', // Orange
            self::Submitted => '#3B82F6', // Blue
            self::Approved => '#10B981', // Green
            self::Rejected => '#EF4444', // Red
            self::Cancelled => '#374151', // Dark Gray
            self::Escalated => '#DC2626', // Dark Red
            self::OnHold => '#D97706', // Dark Orange
            self::RevisionRequested => '#EC4899', // Pink
            self::PayrollBlocked => '#7F1D1D', // Deep Red
            self::ComplianceReview => '#4B5563', // Gray-Blue
            self::Locked => '#111827', // Black/Charcoal
            self::Overdue => '#991B1B', // Darker Red
        };
    }
}
