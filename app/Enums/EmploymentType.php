<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Employment type classifications for employee profiles.
 *
 * Determines the nature of employment relationship between
 * a user and a corporation.
 */
enum EmploymentType: string
{
    case FullTime   = 'full_time';
    case PartTime   = 'part_time';
    case Contractor = 'contractor';
    case Intern     = 'intern';
    case Probation  = 'probation';
    case Consultant = 'consultant';

    /**
     * Get human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::FullTime   => 'Full Time',
            self::PartTime   => 'Part Time',
            self::Contractor => 'Contractor',
            self::Intern     => 'Intern',
            self::Probation  => 'Probation',
            self::Consultant => 'Consultant',
        };
    }
}
