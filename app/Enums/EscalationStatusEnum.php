<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status of an escalation event.
 */
enum EscalationStatusEnum: int
{
    case PENDING = 1;
    case RESOLVED = 2;
    case DISMISSED = 3;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending Resolution',
            self::RESOLVED => 'Resolved',
            self::DISMISSED => 'Dismissed',
        };
    }
}
