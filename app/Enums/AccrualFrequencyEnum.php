<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Frequency of leave accruals.
 */
enum AccrualFrequencyEnum: int
{
    case Monthly = 1;
    case Quarterly = 2;

    public function label(): string
    {
        return match ($this) {
            self::Monthly => 'Monthly',
            self::Quarterly => 'Quarterly',
        };
    }
}
