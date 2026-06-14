<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum ClockSource: int
{
    case Mobile     = 1;
    case Web        = 2;
    case AdminPanel = 3;
    case System     = 4;

    public function label(): string
    {
        return match($this) {
            self::Mobile     => 'Mobile App',
            self::Web        => 'Web Browser',
            self::AdminPanel => 'Admin Panel',
            self::System     => 'System Auto',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Mobile     => 'Clocked in/out via mobile application.',
            self::Web        => 'Clocked in/out via web application.',
            self::AdminPanel => 'Manually added by administrator or manager.',
            self::System     => 'Automatically processed by background system jobs.',
        };
    }
}
