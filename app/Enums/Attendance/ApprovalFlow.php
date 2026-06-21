<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum ApprovalFlow: int
{
    case AUTO               = 1;
    case SINGLE_APPROVAL     = 2;
    case MULTI_LEVEL_APPROVAL = 3;

    public function label(): string
    {
        return match($this) {
            self::AUTO               => 'Auto',
            self::SINGLE_APPROVAL     => 'Single Approval',
            self::MULTI_LEVEL_APPROVAL => 'Multi-Level Approval',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::AUTO               => 'Corrections are immediately accepted without review.',
            self::SINGLE_APPROVAL     => 'Direct manager must approve.',
            self::MULTI_LEVEL_APPROVAL => 'Manager approves first, then HR or Admin.',
        };
    }

    public function requiresApprover(): bool
    {
        return $this !== self::AUTO;
    }

    public function requiresSecondApprover(): bool
    {
        return $this === self::MULTI_LEVEL_APPROVAL;
    }
}
