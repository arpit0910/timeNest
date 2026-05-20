<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status of an escalation event.
 */
enum EscalationStatusEnum: int
{
    case Pending = 1;
    case Resolved = 2;
    case Dismissed = 3;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Resolution',
            self::Resolved => 'Resolved',
            self::Dismissed => 'Dismissed',
        };
    }
}
