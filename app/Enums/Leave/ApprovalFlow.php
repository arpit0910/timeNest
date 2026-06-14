<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum ApprovalFlow: int
{
    case Auto = 1;
    case SingleApproval = 2;
    case MultiLevelApproval = 3;

    public function label(): string
    {
        return match ($this) {
            self::Auto => 'Auto Approve',
            self::SingleApproval => 'Single Approval',
            self::MultiLevelApproval => 'Multi-Level Approval',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Auto => 'Leave requests are automatically approved upon submission.',
            self::SingleApproval => 'Leave requests require approval from one designated manager.',
            self::MultiLevelApproval => 'Leave requests require approval from multiple managers sequentially.',
        };
    }

    public function requiresApprover(): bool
    {
        return in_array($this, [self::SingleApproval, self::MultiLevelApproval], true);
    }

    public function requiresSecondApprover(): bool
    {
        return $this === self::MultiLevelApproval;
    }
}
