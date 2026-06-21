<?php

declare(strict_types=1);

namespace App\Enums\Worklog;

enum WorklogMode: int
{
    case STRICT = 1;
    case FLEXIBLE = 2;
    case HYBRID = 3;

    public function label(): string
    {
        return match ($this) {
            self::STRICT => 'Strict',
            self::FLEXIBLE => 'Flexible',
            self::HYBRID => 'Hybrid',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::STRICT => 'Strict worklog tracking, requires exact time mapping.',
            self::FLEXIBLE => 'Flexible worklog tracking, overall time without strict constraints.',
            self::HYBRID => 'Hybrid approach to worklog tracking.',
        };
    }
}
