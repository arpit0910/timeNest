<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Approval flows for policies.
 */
enum ApprovalFlowEnum: int
{
    case Auto = 1;
    case SingleApproval = 2;
    case MultiLevelApproval = 3;

    public function label(): string
    {
        return match ($this) {
            self::Auto => 'Auto',
            self::SingleApproval => 'Single Approval',
            self::MultiLevelApproval => 'Multi-Level Approval',
        };
    }
}
