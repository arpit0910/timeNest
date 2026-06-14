<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum WorklogStatus: int
{
    case Draft        = 1;
    case Submitted    = 2;
    case Approved     = 3;
    case Rejected     = 4;
    case AutoApproved = 5;
    case Locked       = 6;

    public function label(): string
    {
        return match($this) {
            self::Draft        => 'Draft',
            self::Submitted    => 'Submitted',
            self::Approved     => 'Approved',
            self::Rejected     => 'Rejected',
            self::AutoApproved => 'Auto Approved',
            self::Locked       => 'Locked',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Draft        => 'Worklog is currently being drafted by the employee.',
            self::Submitted    => 'Worklog has been submitted and is pending review.',
            self::Approved     => 'Worklog has been manually approved by a manager.',
            self::Rejected     => 'Worklog has been rejected and requires correction.',
            self::AutoApproved => 'Worklog was automatically approved by system policy.',
            self::Locked       => 'Worklog is locked and can no longer be edited.',
        };
    }
}
