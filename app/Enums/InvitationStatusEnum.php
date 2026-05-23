<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Backend Enum for Invitation Statuses.
 */
enum InvitationStatusEnum: int
{
    case Pending = 1;
    case Accepted = 2;
    case Expired = 3;
    case Revoked = 4;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Accepted => 'Accepted',
            self::Expired => 'Expired',
            self::Revoked => 'Revoked',
        };
    }
}
