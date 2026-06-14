<?php

declare(strict_types=1);

namespace App\Enums\Organization;

enum OrganizationType: int
{
    case Personal     = 1;
    case Team         = 2;
    case Organization = 3;

    public function label(): string
    {
        return match($this) {
            self::Personal     => 'Personal',
            self::Team         => 'Team',
            self::Organization => 'Organization',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Personal     => 'Single-user freelancer workspace. Attendance, leave, and worklog modules are suppressed at the API layer.',
            self::Team         => 'Small team. Basic attendance and worklog available. Leave module is optional.',
            self::Organization => 'Full enterprise workspace. All policy-driven modules available including leave, multi-level approvals, escalations, and reporting.',
        };
    }
}
