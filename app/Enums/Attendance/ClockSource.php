<?php

declare(strict_types=1);

namespace App\Enums\Attendance;

enum ClockSource: int
{
    case MOBILE     = 1;
    case WEB        = 2;
    case ADMIN_PANEL = 3;
    case SYSTEM     = 4;

    public function label(): string
    {
        return match($this) {
            self::MOBILE     => 'Mobile App',
            self::WEB        => 'Web Browser',
            self::ADMIN_PANEL => 'Admin Panel',
            self::SYSTEM     => 'System Auto',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::MOBILE     => 'Clocked in/out via mobile application.',
            self::WEB        => 'Clocked in/out via web application.',
            self::ADMIN_PANEL => 'Manually added by administrator or manager.',
            self::SYSTEM     => 'Automatically processed by background system jobs.',
        };
    }
}
