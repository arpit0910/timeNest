<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Sources for attendance session entry.
 */
enum AttendanceSessionSourceEnum: int
{
    case MOBILE = 1;
    case WEB = 2;
    case ADMIN_PANEL = 3;
    case SYSTEM = 4;

    public function label(): string
    {
        return match ($this) {
            self::MOBILE => 'Mobile App',
            self::WEB => 'Web Portal',
            self::ADMIN_PANEL => 'Admin Panel',
            self::SYSTEM => 'System Automations',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MOBILE => '#3B82F6', // Blue
            self::WEB => '#10B981', // Green
            self::ADMIN_PANEL => '#8B5CF6', // Purple
            self::SYSTEM => '#6B7280', // Gray
        };
    }
}
