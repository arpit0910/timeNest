<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status of attendance adjustment requests.
 */
enum AttendanceAdjustmentStatusEnum: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case CANCELLED = 4;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => '#F59E0B', // Orange
            self::APPROVED => '#10B981', // Green
            self::REJECTED => '#EF4444', // Red
            self::CANCELLED => '#6B7280', // Gray
        };
    }
}
