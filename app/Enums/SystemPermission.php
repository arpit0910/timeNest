<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * All system-defined permissions following {module}.{action} convention.
 *
 * Every permission in the system MUST be defined here.
 * Seeders, middleware, and route definitions consume this enum exclusively.
 *
 * Naming convention:
 * - Module: plural noun (e.g., users, branches, attendance)
 * - Action: verb (e.g., view, create, edit, delete, manage, export, approve)
 * - Format: {module}.{action}
 */
enum SystemPermission: string
{
    // ─── Organizations (Platform-level) ───────────────────────────
    case ORGANIZATIONS_MANAGE = 'organizations.manage';

    // ─── Users ───────────────────────────────────────────────────
    case USERS_VIEW = 'users.view';
    case USERS_INVITE = 'users.invite';
    case USERS_EDIT = 'users.edit';
    case USERS_DELETE = 'users.delete';
    case USERS_MANAGE = 'users.manage';
    case USERS_EXPORT = 'users.export';
    case EMPLOYEE_PROFILE_VIEW = 'employee_profile.view';
    case EMPLOYEE_PROFILE_MANAGE = 'employee_profile.manage';

    // ─── Role management ─────────────────────────────────────────
    case ROLES_VIEW              = 'roles.view';
    case ROLES_CREATE            = 'roles.create';
    case ROLES_EDIT              = 'roles.edit';
    case ROLES_DELETE            = 'roles.delete';
    case ROLES_ASSIGN_PERMISSIONS = 'roles.assign_permissions';

    // Platform-only role management (global roles)
    case PLATFORM_ROLES_MANAGE   = 'platform.roles.manage';

    // ─── Attendance ──────────────────────────────────────────────
    case ATTENDANCE_VIEW = 'attendance.view';
    case ATTENDANCE_CREATE = 'attendance.create';
    case ATTENDANCE_EDIT = 'attendance.edit';
    case ATTENDANCE_DELETE = 'attendance.delete';
    case ATTENDANCE_APPROVE = 'attendance.approve';
    case ATTENDANCE_APPROVE_ANY = 'attendance.approve_any';
    case ATTENDANCE_EXPORT = 'attendance.export';
    case ATTENDANCE_IMPORT = 'attendance.import';
    case ATTENDANCE_POLICY_VIEW = 'attendance_policy.view';
    case ATTENDANCE_POLICY_MANAGE = 'attendance_policy.manage';
    case ATTENDANCE_ADJUSTMENTS_VIEW = 'attendance_adjustments.view';
    case ATTENDANCE_ADJUSTMENTS_CREATE = 'attendance_adjustments.create';
    case ATTENDANCE_ESCALATIONS_VIEW = 'attendance_escalations.view';
    case ATTENDANCE_ESCALATIONS_RESOLVE = 'attendance_escalations.resolve';
    case WORKLOG_VIEW = 'worklog.view';
    case WORKLOG_CREATE = 'worklog.create';
    case WORKLOG_APPROVE = 'worklog.approve';
    case WORKLOG_APPROVE_ANY = 'worklog.approve_any';
    case WORKLOG_POLICY_VIEW = 'worklog_policy.view';
    case WORKLOG_POLICY_MANAGE = 'worklog_policy.manage';
    case LEAVE_POLICY_VIEW = 'leave_policy.view';
    case LEAVE_POLICY_MANAGE = 'leave_policy.manage';

    // ─── Payroll ─────────────────────────────────────────────────
    case PAYROLL_VIEW = 'payroll.view';
    case PAYROLL_CREATE = 'payroll.create';
    case PAYROLL_EDIT = 'payroll.edit';
    case PAYROLL_DELETE = 'payroll.delete';
    case PAYROLL_EXPORT = 'payroll.export';
    case PAYROLL_APPROVE = 'payroll.approve';
    case PAYROLL_PROCESS = 'payroll.process';

    // ─── HRMS ────────────────────────────────────────────────────
    case HRMS_VIEW = 'hrms.view';
    case HRMS_CREATE = 'hrms.create';
    case HRMS_EDIT = 'hrms.edit';
    case HRMS_DELETE = 'hrms.delete';
    case HRMS_EXPORT = 'hrms.export';

    // ─── Leaves ──────────────────────────────────────────────────
    case LEAVES_VIEW = 'leaves.view';
    case LEAVES_CREATE = 'leaves.create';
    case LEAVES_EDIT = 'leaves.edit';
    case LEAVES_DELETE = 'leaves.delete';
    case LEAVES_APPROVE = 'leaves.approve';
    case LEAVES_APPROVE_ANY = 'leaves.approve_any';
    case LEAVES_EXPORT = 'leaves.export';

    // ─── Invitations ─────────────────────────────────────────────
    case INVITATIONS_VIEW = 'invitations.view';
    case INVITATIONS_CREATE = 'invitations.create';
    case INVITATIONS_REVOKE = 'invitations.revoke';
    case INVITATIONS_RESEND = 'invitations.resend';

    // ─── Branches ────────────────────────────────────────────────
    case BRANCHES_VIEW = 'branches.view';
    case BRANCHES_CREATE = 'branches.create';
    case BRANCHES_EDIT = 'branches.edit';
    case BRANCHES_DELETE = 'branches.delete';
    case BRANCHES_MANAGE = 'branches.manage';

    // ─── Departments ─────────────────────────────────────────────
    case DEPARTMENTS_VIEW = 'departments.view';
    case DEPARTMENTS_CREATE = 'departments.create';
    case DEPARTMENTS_EDIT = 'departments.edit';
    case DEPARTMENTS_DELETE = 'departments.delete';
    case DEPARTMENTS_MANAGE = 'departments.manage';

    // Sub-Department permissions
    case SUB_DEPARTMENTS_VIEW   = 'sub_departments.view';
    case SUB_DEPARTMENTS_CREATE = 'sub_departments.create';
    case SUB_DEPARTMENTS_EDIT   = 'sub_departments.edit';
    case SUB_DEPARTMENTS_DELETE = 'sub_departments.delete';

    // Designation permissions
    case DESIGNATIONS_VIEW   = 'designations.view';
    case DESIGNATIONS_CREATE = 'designations.create';
    case DESIGNATIONS_EDIT   = 'designations.edit';
    case DESIGNATIONS_DELETE = 'designations.delete';

    // Member hierarchy management
    case MEMBERS_ASSIGN_DESIGNATION = 'members.assign_designation';
    case MEMBERS_VIEW_HIERARCHY     = 'members.view_hierarchy';
    case DEPARTMENTS_ASSIGN_HEAD    = 'departments.assign_head';
    case SUB_DEPARTMENTS_ASSIGN_HEAD = 'sub_departments.assign_head';

    // ─── Reports ─────────────────────────────────────────────────
    case REPORTS_VIEW = 'reports.view';
    case REPORTS_EXPORT = 'reports.export';
    case REPORTS_SCHEDULE = 'reports.schedule';

    // ─── Settings ────────────────────────────────────────────────
    case SETTINGS_MANAGE = 'settings.manage';

    // ─── Invoicing ───────────────────────────────────────────────
    case INVOICING_VIEW = 'invoicing.view';
    case INVOICING_CREATE = 'invoicing.create';
    case INVOICING_EDIT = 'invoicing.edit';
    case INVOICING_DELETE = 'invoicing.delete';
    case INVOICING_SEND = 'invoicing.send';
    case INVOICING_APPROVE = 'invoicing.approve';

    // ─── Workflows ───────────────────────────────────────────────
    case WORKFLOWS_VIEW = 'workflows.view';
    case WORKFLOWS_CREATE = 'workflows.create';
    case WORKFLOWS_EDIT = 'workflows.edit';
    case WORKFLOWS_DELETE = 'workflows.delete';
    case WORKFLOWS_TRIGGER = 'workflows.trigger';

    /**
     * Extract the module segment from the permission name.
     */
    public function module(): string
    {
        return explode('.', $this->value)[0];
    }

    /**
     * Extract the action segment from the permission name.
     */
    public function action(): string
    {
        return explode('.', $this->value)[1];
    }

    /**
     * Get human-readable description.
     */
    public function description(): string
    {
        return ucfirst($this->action()).' '.$this->module();
    }

    /**
     * Get all permissions for a given module.
     *
     * @return self[]
     */
    public static function forModule(string $module): array
    {
        return array_filter(self::cases(), fn (self $p) => $p->module() === $module);
    }

    /**
     * Get all platform-only permissions (organizations module).
     *
     * @return self[]
     */
    public static function platformPermissions(): array
    {
        return self::forModule(SystemModule::ORGANIZATIONS->value);
    }

    /**
     * Get all permission values as a flat array of strings.
     *
     * @return string[]
     */
    public static function allValues(): array
    {
        return array_map(fn (self $p) => $p->value, self::cases());
    }
}
