<?php

declare(strict_types=1);

namespace App\Enums\Leave;

enum AccrualFrequency: int
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

    public function description(): string
    {
        return match ($this) {
            self::Monthly => 'Leave balance is accrued on a monthly basis.',
            self::Quarterly => 'Leave balance is accrued on a quarterly basis.',
        };
    }
}
