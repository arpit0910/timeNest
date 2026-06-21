<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Frequency of leave accruals.
 */
enum AccrualFrequencyEnum: int
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
}
