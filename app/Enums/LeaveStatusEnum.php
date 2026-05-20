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
    case Approved = 3;
    case Rejected = 4;
    case Cancelled = 5;
    case Expired = 6;
    case AutoApproved = 7;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending Approval',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
            self::Expired => 'Expired',
            self::AutoApproved => 'Auto Approved',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => '#6B7280', // Gray
            self::Pending => '#F59E0B', // Orange
            self::Approved => '#10B981', // Green
            self::Rejected => '#EF4444', // Red
            self::Cancelled => '#374151', // Dark Gray
            self::Expired => '#9CA3AF', // Gray
            self::AutoApproved => '#059669', // Dark Green
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
