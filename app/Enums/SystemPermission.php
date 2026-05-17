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
    // ─── Corporations (Platform-level) ───────────────────────────
    case CorporationsManage = 'corporations.manage';

    // ─── Users ───────────────────────────────────────────────────
    case UsersView = 'users.view';
    case UsersInvite = 'users.invite';
    case UsersEdit = 'users.edit';
    case UsersDelete = 'users.delete';
    case UsersManage = 'users.manage';
    case UsersExport = 'users.export';

    // ─── Attendance ──────────────────────────────────────────────
    case AttendanceView = 'attendance.view';
    case AttendanceCreate = 'attendance.create';
    case AttendanceEdit = 'attendance.edit';
    case AttendanceDelete = 'attendance.delete';
    case AttendanceApprove = 'attendance.approve';
    case AttendanceExport = 'attendance.export';
    case AttendanceImport = 'attendance.import';

    // ─── Payroll ─────────────────────────────────────────────────
    case PayrollView = 'payroll.view';
    case PayrollCreate = 'payroll.create';
    case PayrollEdit = 'payroll.edit';
    case PayrollDelete = 'payroll.delete';
    case PayrollExport = 'payroll.export';
    case PayrollApprove = 'payroll.approve';
    case PayrollProcess = 'payroll.process';

    // ─── HRMS ────────────────────────────────────────────────────
    case HrmsView = 'hrms.view';
    case HrmsCreate = 'hrms.create';
    case HrmsEdit = 'hrms.edit';
    case HrmsDelete = 'hrms.delete';
    case HrmsExport = 'hrms.export';

    // ─── Leaves ──────────────────────────────────────────────────
    case LeavesView = 'leaves.view';
    case LeavesCreate = 'leaves.create';
    case LeavesEdit = 'leaves.edit';
    case LeavesDelete = 'leaves.delete';
    case LeavesApprove = 'leaves.approve';
    case LeavesExport = 'leaves.export';

    // ─── Branches ────────────────────────────────────────────────
    case BranchesView = 'branches.view';
    case BranchesCreate = 'branches.create';
    case BranchesEdit = 'branches.edit';
    case BranchesDelete = 'branches.delete';
    case BranchesManage = 'branches.manage';

    // ─── Departments ─────────────────────────────────────────────
    case DepartmentsView = 'departments.view';
    case DepartmentsCreate = 'departments.create';
    case DepartmentsEdit = 'departments.edit';
    case DepartmentsDelete = 'departments.delete';
    case DepartmentsManage = 'departments.manage';

    // ─── Reports ─────────────────────────────────────────────────
    case ReportsView = 'reports.view';
    case ReportsExport = 'reports.export';
    case ReportsSchedule = 'reports.schedule';

    // ─── Settings ────────────────────────────────────────────────
    case SettingsManage = 'settings.manage';

    // ─── Invoicing ───────────────────────────────────────────────
    case InvoicingView = 'invoicing.view';
    case InvoicingCreate = 'invoicing.create';
    case InvoicingEdit = 'invoicing.edit';
    case InvoicingDelete = 'invoicing.delete';
    case InvoicingSend = 'invoicing.send';
    case InvoicingApprove = 'invoicing.approve';

    // ─── Workflows ───────────────────────────────────────────────
    case WorkflowsView = 'workflows.view';
    case WorkflowsCreate = 'workflows.create';
    case WorkflowsEdit = 'workflows.edit';
    case WorkflowsDelete = 'workflows.delete';
    case WorkflowsTrigger = 'workflows.trigger';

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
     * Get all platform-only permissions (corporations module).
     *
     * @return self[]
     */
    public static function platformPermissions(): array
    {
        return self::forModule(SystemModule::Corporations->value);
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
