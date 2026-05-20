<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Statuses of a leave application.
 */
enum LeaveStatusEnum: int
{
    case Draft = 1;
    case Pending = 2;
    case ManagerApproved = 3;
    case HRApproved = 4;
    case Approved = 5;
    case Rejected = 6;
    case Cancelled = 7;
    case Expired = 8;
    case AutoApproved = 9;
    case Escalated = 10;
    case OnHold = 11;
    case RevisionRequested = 12;
    case PayrollBlocked = 13;
    case ComplianceReview = 14;
    case PartiallyApproved = 15;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending Approval',
            self::ManagerApproved => 'Manager Approved',
            self::HRApproved => 'HR Approved',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
            self::Expired => 'Expired',
            self::AutoApproved => 'Auto Approved',
            self::Escalated => 'Escalated',
            self::OnHold => 'On Hold',
            self::RevisionRequested => 'Revision Requested',
            self::PayrollBlocked => 'Payroll Blocked',
            self::ComplianceReview => 'Compliance Review',
            self::PartiallyApproved => 'Partially Approved',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => '#6B7280', // Gray
            self::Pending => '#F59E0B', // Orange
            self::ManagerApproved => '#3B82F6', // Blue
            self::HRApproved => '#8B5CF6', // Purple
            self::Approved => '#10B981', // Green
            self::Rejected => '#EF4444', // Red
            self::Cancelled => '#374151', // Dark Gray
            self::Expired => '#9CA3AF', // Gray
            self::AutoApproved => '#059669', // Dark Green
            self::Escalated => '#DC2626', // Dark Red
            self::OnHold => '#D97706', // Dark Orange
            self::RevisionRequested => '#EC4899', // Pink
            self::PayrollBlocked => '#7F1D1D', // Deep Red
            self::ComplianceReview => '#4B5563', // Gray-Blue
            self::PartiallyApproved => '#10B981', // Green
        };
    }

    public function isApproved(): bool
    {
        return in_array($this, [self::Approved, self::AutoApproved], true);
    }

    public function isPending(): bool
    {
        return $this === self::Pending;
    }

    public function isRejected(): bool
    {
        return $this === self::Rejected;
    }

    public function isCancelled(): bool
    {
        return $this === self::Cancelled;
    }
}
