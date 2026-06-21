<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum AccrualFrequency: int
{
    case MONTHLY = 1;
    case QUARTERLY = 2;

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly',
            self::QUARTERLY => 'Quarterly',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::MONTHLY => 'Leave balance is accrued on a monthly basis.',
            self::QUARTERLY => 'Leave balance is accrued on a quarterly basis.',
        };
    }
}
