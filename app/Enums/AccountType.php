<?php

declare(strict_types=1);

namespace App\Enums;

enum AccountType: string
{
    case ORGANIZATION = 'organization';
    case FREELANCE_TEAM = 'freelance_team';
    case FREELANCER = 'freelancer';

    public function label(): string
    {
        return match ($this) {
            self::ORGANIZATION => 'Organization',
            self::FREELANCE_TEAM => 'Freelance Team',
            self::FREELANCER => 'Freelancer',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ORGANIZATION => 'For companies and businesses managing employees, attendance, and workflows under one workspace.',
            self::FREELANCE_TEAM => 'For a small group of independent freelancers working together, with one person owning the team and everyone tracking their own attendance.',
            self::FREELANCER => 'For individuals working solo — track your own time and activity without any team or organization.',
        };
    }
}
