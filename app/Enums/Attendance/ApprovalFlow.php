<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum ApprovalFlow: int
{
    case Auto               = 1;
    case SingleApproval     = 2;
    case MultiLevelApproval = 3;

    public function label(): string
    {
        return match($this) {
            self::Auto               => 'Auto',
            self::SingleApproval     => 'Single Approval',
            self::MultiLevelApproval => 'Multi-Level Approval',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Auto               => 'Corrections are immediately accepted without review.',
            self::SingleApproval     => 'Direct manager must approve.',
            self::MultiLevelApproval => 'Manager approves first, then HR or Admin.',
        };
    }

    public function requiresApprover(): bool
    {
        return $this !== self::Auto;
    }

    public function requiresSecondApprover(): bool
    {
        return $this === self::MultiLevelApproval;
    }
}
