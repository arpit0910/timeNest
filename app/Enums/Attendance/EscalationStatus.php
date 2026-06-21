<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum EscalationStatus: int
{
    case PENDING      = 1;
    case ACKNOWLEDGED = 2;
    case RESOLVED     = 3;
    case DISMISSED    = 4;

    public function label(): string
    {
        return match($this) {
            self::PENDING      => 'Pending',
            self::ACKNOWLEDGED => 'Acknowledged',
            self::RESOLVED     => 'Resolved',
            self::DISMISSED    => 'Dismissed',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::PENDING      => 'Escalation is awaiting review by a manager or HR.',
            self::ACKNOWLEDGED => 'Escalation has been seen and is actively being handled.',
            self::RESOLVED     => 'Escalation has been handled and corrective action applied.',
            self::DISMISSED    => 'Escalation was reviewed and deemed invalid or excused.',
        };
    }
}
