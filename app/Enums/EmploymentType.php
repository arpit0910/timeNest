<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Employment type classifications for employee profiles.
 *
 * Determines the nature of employment relationship between
 * a user and an organization.
 */
enum EmploymentType: string
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case CONTRACTOR = 'contractor';
    case INTERN = 'intern';
    case PROBATION = 'probation';
    case CONSULTANT = 'consultant';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full Time',
            self::PART_TIME => 'Part Time',
            self::CONTRACTOR => 'Contractor',
            self::INTERN => 'Intern',
            self::PROBATION => 'Probation',
            self::CONSULTANT => 'Consultant',
        };
    }
}
