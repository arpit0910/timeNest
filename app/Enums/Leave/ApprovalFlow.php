<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum ApprovalFlow: int
{
    case AUTO = 1;
    case SINGLE_APPROVAL = 2;
    case MULTI_LEVEL_APPROVAL = 3;

    public function label(): string
    {
        return match ($this) {
            self::AUTO => 'Auto Approve',
            self::SINGLE_APPROVAL => 'Single Approval',
            self::MULTI_LEVEL_APPROVAL => 'Multi-Level Approval',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::AUTO => 'Leave requests are automatically approved upon submission.',
            self::SINGLE_APPROVAL => 'Leave requests require approval from one designated manager.',
            self::MULTI_LEVEL_APPROVAL => 'Leave requests require approval from multiple managers sequentially.',
        };
    }

    public function requiresApprover(): bool
    {
        return in_array($this, [self::SINGLE_APPROVAL, self::MULTI_LEVEL_APPROVAL], true);
    }

    public function requiresSecondApprover(): bool
    {
        return $this === self::MULTI_LEVEL_APPROVAL;
    }
}
