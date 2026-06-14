<?php

declare(strict_types=1);

namespace App\Enums\Worklog;

enum WorklogMode: int
{
    case Strict = 1;
    case Flexible = 2;
    case Hybrid = 3;

    public function label(): string
    {
        return match ($this) {
            self::Strict => 'Strict',
            self::Flexible => 'Flexible',
            self::Hybrid => 'Hybrid',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Strict => 'Strict worklog tracking, requires exact time mapping.',
            self::Flexible => 'Flexible worklog tracking, overall time without strict constraints.',
            self::Hybrid => 'Hybrid approach to worklog tracking.',
        };
    }
}
