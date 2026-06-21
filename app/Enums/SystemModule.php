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
    case ORGANIZATIONS = 'organizations';
    case USERS = 'users';
    case BRANCHES = 'branches';
    case DEPARTMENTS = 'departments';
    case ATTENDANCE = 'attendance';
    case PAYROLL = 'payroll';
    case HRMS = 'hrms';
    case LEAVES = 'leaves';
    case REPORTS = 'reports';
    case SETTINGS = 'settings';
    case INVOICING = 'invoicing';
    case WORKFLOWS = 'workflows';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::ORGANIZATIONS => 'Organization Management',
            self::USERS => 'User Management',
            self::BRANCHES => 'Branch Management',
            self::DEPARTMENTS => 'Department Management',
            self::ATTENDANCE => 'Attendance Management',
            self::PAYROLL => 'Payroll Management',
            self::HRMS => 'HRMS',
            self::LEAVES => 'Leave Management',
            self::REPORTS => 'Reports & Analytics',
            self::SETTINGS => 'System Settings',
            self::INVOICING => 'Invoicing & Billing',
            self::WORKFLOWS => 'Workflow Automation',
        };
    }
}
