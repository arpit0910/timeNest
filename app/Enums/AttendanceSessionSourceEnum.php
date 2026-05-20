<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Sources for attendance session entry.
 */
enum AttendanceSessionSourceEnum: int
{
    case Mobile = 1;
    case Web = 2;
    case AdminPanel = 3;
    case System = 4;

    public function label(): string
    {
        return match ($this) {
            self::Mobile => 'Mobile App',
            self::Web => 'Web Portal',
            self::AdminPanel => 'Admin Panel',
            self::System => 'System Automations',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Mobile => '#3B82F6', // Blue
            self::Web => '#10B981', // Green
            self::AdminPanel => '#8B5CF6', // Purple
            self::System => '#6B7280', // Gray
        };
    }
}
