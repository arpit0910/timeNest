<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Centralized Workflow Status Enum for system-wide state transitions.
 */
enum WorkflowStatusEnum: int
{
    case DRAFT = 1;
    case PENDING = 2;
    case SUBMITTED = 3;
    case APPROVED = 4;
    case REJECTED = 5;
    case CANCELLED = 6;
    case ESCALATED = 7;
    case ON_HOLD = 8;
    case REVISION_REQUESTED = 9;
    case PAYROLL_BLOCKED = 10;
    case COMPLIANCE_REVIEW = 11;
    case LOCKED = 12;
    case OVERDUE = 13;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::SUBMITTED => 'Submitted',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
            self::ESCALATED => 'Escalated',
            self::ON_HOLD => 'On Hold',
            self::REVISION_REQUESTED => 'Revision Requested',
            self::PAYROLL_BLOCKED => 'Payroll Blocked',
            self::COMPLIANCE_REVIEW => 'Compliance Review',
            self::LOCKED => 'Locked',
            self::OVERDUE => 'Overdue',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => '#6B7280', // Gray
            self::PENDING => '#F59E0B', // Orange
            self::SUBMITTED => '#3B82F6', // Blue
            self::APPROVED => '#10B981', // Green
            self::REJECTED => '#EF4444', // Red
            self::CANCELLED => '#374151', // Dark Gray
            self::ESCALATED => '#DC2626', // Dark Red
            self::ON_HOLD => '#D97706', // Dark Orange
            self::REVISION_REQUESTED => '#EC4899', // Pink
            self::PAYROLL_BLOCKED => '#7F1D1D', // Deep Red
            self::COMPLIANCE_REVIEW => '#4B5563', // Gray-Blue
            self::LOCKED => '#111827', // Black/Charcoal
            self::OVERDUE => '#991B1B', // Darker Red
        };
    }
}
