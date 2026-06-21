<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Approval flows for policies.
 */
enum ApprovalFlowEnum: int
{
    case AUTO = 1;
    case SINGLE_APPROVAL = 2;
    case MULTI_LEVEL_APPROVAL = 3;

    public function label(): string
    {
        return match ($this) {
            self::AUTO => 'Auto',
            self::SINGLE_APPROVAL => 'Single Approval',
            self::MULTI_LEVEL_APPROVAL => 'Multi-Level Approval',
        };
    }
}
