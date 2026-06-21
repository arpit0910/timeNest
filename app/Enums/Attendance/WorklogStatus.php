<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum WorklogStatus: int
{
    case DRAFT        = 1;
    case SUBMITTED    = 2;
    case APPROVED     = 3;
    case REJECTED     = 4;
    case AUTO_APPROVED = 5;
    case LOCKED       = 6;

    public function label(): string
    {
        return match($this) {
            self::DRAFT        => 'Draft',
            self::SUBMITTED    => 'Submitted',
            self::APPROVED     => 'Approved',
            self::REJECTED     => 'Rejected',
            self::AUTO_APPROVED => 'Auto Approved',
            self::LOCKED       => 'Locked',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::DRAFT        => 'Worklog is currently being drafted by the employee.',
            self::SUBMITTED    => 'Worklog has been submitted and is pending review.',
            self::APPROVED     => 'Worklog has been manually approved by a manager.',
            self::REJECTED     => 'Worklog has been rejected and requires correction.',
            self::AUTO_APPROVED => 'Worklog was automatically approved by system policy.',
            self::LOCKED       => 'Worklog is locked and can no longer be edited.',
        };
    }
}
