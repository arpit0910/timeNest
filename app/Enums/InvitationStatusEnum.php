<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Backend Enum for Invitation Statuses.
 */
enum InvitationStatusEnum: int
{
    case PENDING = 1;
    case ACCEPTED = 2;
    case EXPIRED = 3;
    case REVOKED = 4;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::EXPIRED => 'Expired',
            self::REVOKED => 'Revoked',
        };
    }
}
