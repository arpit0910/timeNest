<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum EscalationStatus: int
{
    case Pending      = 1;
    case Acknowledged = 2;
    case Resolved     = 3;
    case Dismissed    = 4;

    public function label(): string
    {
        return match($this) {
            self::Pending      => 'Pending',
            self::Acknowledged => 'Acknowledged',
            self::Resolved     => 'Resolved',
            self::Dismissed    => 'Dismissed',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Pending      => 'Escalation is awaiting review by a manager or HR.',
            self::Acknowledged => 'Escalation has been seen and is actively being handled.',
            self::Resolved     => 'Escalation has been handled and corrective action applied.',
            self::Dismissed    => 'Escalation was reviewed and deemed invalid or excused.',
        };
    }
}
