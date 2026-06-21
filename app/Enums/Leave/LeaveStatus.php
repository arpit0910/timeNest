<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum LeaveStatus: int
{
    case DRAFT = 1;
    case PENDING = 2;
    case APPROVED = 3;
    case REJECTED = 4;
    case CANCELLED = 5;
    case EXPIRED = 6;
    case AUTO_APPROVED = 7;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
            self::AUTO_APPROVED => 'Auto Approved',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::DRAFT => 'Leave request is saved as a draft and not yet submitted.',
            self::PENDING => 'Leave request is pending approval.',
            self::APPROVED => 'Leave request has been approved.',
            self::REJECTED => 'Leave request has been rejected.',
            self::CANCELLED => 'Leave request has been cancelled.',
            self::EXPIRED => 'Leave request has expired.',
            self::AUTO_APPROVED => 'Leave request was automatically approved.',
        };
    }
}
