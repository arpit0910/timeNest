<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Module registry — every feature module in the TimeNest platform.
 *
 * Used for permission grouping, module-level access control, and
 * future subscription/feature-flag gating.
 */
enum SystemModule: string
{
    case Organizations = 'organizations';
    case Users = 'users';
    case Branches = 'branches';
    case Departments = 'departments';
    case Attendance = 'attendance';
    case Payroll = 'payroll';
    case Hrms = 'hrms';
    case Leaves = 'leaves';
    case Reports = 'reports';
    case Settings = 'settings';
    case Invoicing = 'invoicing';
    case Workflows = 'workflows';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Organizations => 'Organization Management',
            self::Users => 'User Management',
            self::Branches => 'Branch Management',
            self::Departments => 'Department Management',
            self::Attendance => 'Attendance Management',
            self::Payroll => 'Payroll Management',
            self::Hrms => 'HRMS',
            self::Leaves => 'Leave Management',
            self::Reports => 'Reports & Analytics',
            self::Settings => 'System Settings',
            self::Invoicing => 'Invoicing & Billing',
            self::Workflows => 'Workflow Automation',
        };
    }
}
