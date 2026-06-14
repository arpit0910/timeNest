<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum LeaveStatus: int
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
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
            self::Expired => 'Expired',
            self::AutoApproved => 'Auto Approved',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Draft => 'Leave request is saved as a draft and not yet submitted.',
            self::Pending => 'Leave request is pending approval.',
            self::Approved => 'Leave request has been approved.',
            self::Rejected => 'Leave request has been rejected.',
            self::Cancelled => 'Leave request has been cancelled.',
            self::Expired => 'Leave request has expired.',
            self::AutoApproved => 'Leave request was automatically approved.',
        };
    }
}
