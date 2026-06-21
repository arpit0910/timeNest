<?php

declare(strict_types=1);

namespace App\Enums\Organization;

enum OrganizationType: int
{
    case PERSONAL     = 1;
    case TEAM         = 2;
    case ORGANIZATION = 3;

    public function label(): string
    {
        return match($this) {
            self::PERSONAL     => 'Personal',
            self::TEAM         => 'Team',
            self::ORGANIZATION => 'Organization',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::PERSONAL     => 'Single-user freelancer workspace. Attendance, leave, and worklog modules are suppressed at the API layer.',
            self::TEAM         => 'Small team. Basic attendance and worklog available. Leave module is optional.',
            self::ORGANIZATION => 'Full enterprise workspace. All policy-driven modules available including leave, multi-level approvals, escalations, and reporting.',
        };
    }
}
