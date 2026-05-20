<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status of attendance adjustment requests.
 */
enum AttendanceAdjustmentStatusEnum: int
{
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;
    case Cancelled = 4;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => '#F59E0B', // Orange
            self::Approved => '#10B981', // Green
            self::Rejected => '#EF4444', // Red
            self::Cancelled => '#6B7280', // Gray
        };
    }
}
