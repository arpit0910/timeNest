<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;

/**
 * Maps permissions to system roles using Spatie Laravel Permission.
 *
 * Permission assignment per role as defined in the master architecture.
 * All references use SystemRole and SystemPermission enums — zero hardcoded strings.
 */
class PlatformRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping.
     * Uses enum references exclusively.
     * null = all permissions (wildcard).
     *
     * @return array<string, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // ─── Platform roles ─────────────────────────────────────
            SystemRole::APP_DIRECTOR->value    => null, // ALL permissions
            SystemRole::APP_SUPER_ADMIN->value => null, // ALL permissions
            SystemRole::APP_ADMIN->value       => [
                SystemPermission::ORGANIZATIONS_MANAGE,
                SystemPermission::USERS_VIEW,
                SystemPermission::USERS_EDIT,
                SystemPermission::USERS_MANAGE,
                SystemPermission::ROLES_VIEW,
                SystemPermission::ROLES_EDIT,
                SystemPermission::ROLES_ASSIGN_PERMISSIONS,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::ATTENDANCE_VIEW,
            ],
            SystemRole::APP_SUPPORT->value => [
                SystemPermission::USERS_VIEW,
                SystemPermission::ROLES_VIEW,
                SystemPermission::REPORTS_VIEW,
            ],
            SystemRole::APP_AUDITOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::USERS_VIEW,
                SystemPermission::ROLES_VIEW,
                SystemPermission::USERS_EXPORT,
                SystemPermission::PAYROLL_VIEW,
                SystemPermission::PAYROLL_EXPORT,
                SystemPermission::HRMS_VIEW,
                SystemPermission::HRMS_EXPORT,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_EXPORT,
                SystemPermission::BRANCHES_VIEW,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::REPORTS_EXPORT,
            ],

            // ─── Organization roles ─────────────────────────────────
            SystemRole::DIRECTOR->value    => null, // ALL permissions
            SystemRole::SUPER_ADMIN->value => null, // ALL permissions (billing excluded at app layer)
            SystemRole::ADMIN->value       => [
                SystemPermission::USERS_VIEW,
                SystemPermission::USERS_INVITE,
                SystemPermission::USERS_EDIT,
                SystemPermission::USERS_DELETE,
                SystemPermission::USERS_MANAGE,
                SystemPermission::USERS_EXPORT,
                SystemPermission::INVITATIONS_VIEW,
                SystemPermission::INVITATIONS_CREATE,
                SystemPermission::INVITATIONS_REVOKE,
                SystemPermission::INVITATIONS_RESEND,
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::ATTENDANCE_EDIT,
                SystemPermission::ATTENDANCE_DELETE,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::ATTENDANCE_APPROVE_ANY,
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::ATTENDANCE_IMPORT,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_POLICY_VIEW,
                SystemPermission::ATTENDANCE_POLICY_MANAGE,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::REPORTS_EXPORT,
                SystemPermission::BRANCHES_VIEW,
                SystemPermission::BRANCHES_CREATE,
                SystemPermission::BRANCHES_EDIT,
                SystemPermission::BRANCHES_DELETE,
                SystemPermission::BRANCHES_MANAGE,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::DEPARTMENTS_CREATE,
                SystemPermission::DEPARTMENTS_EDIT,
                SystemPermission::DEPARTMENTS_DELETE,
                SystemPermission::DEPARTMENTS_MANAGE,
                SystemPermission::SETTINGS_MANAGE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::WORKLOG_APPROVE_ANY,
                SystemPermission::WORKLOG_POLICY_VIEW,
                SystemPermission::WORKLOG_POLICY_MANAGE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::LEAVES_APPROVE_ANY,
                SystemPermission::LEAVE_POLICY_VIEW,
                SystemPermission::LEAVE_POLICY_MANAGE,
            ],
            SystemRole::HEAD->value => [
                // Same as department_admin + can manage department members
                SystemPermission::USERS_VIEW,
                SystemPermission::USERS_INVITE,
                SystemPermission::INVITATIONS_VIEW,
                SystemPermission::INVITATIONS_CREATE,
                SystemPermission::INVITATIONS_RESEND,
                SystemPermission::HRMS_VIEW,
                SystemPermission::HRMS_CREATE,
                SystemPermission::HRMS_EDIT,
                SystemPermission::HRMS_DELETE,
                SystemPermission::HRMS_EXPORT,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::LEAVES_EDIT,
                SystemPermission::LEAVES_DELETE,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::LEAVES_APPROVE_ANY,
                SystemPermission::LEAVES_EXPORT,
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::ATTENDANCE_EDIT,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::ATTENDANCE_APPROVE_ANY,
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_POLICY_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::WORKLOG_APPROVE_ANY,
                SystemPermission::WORKLOG_POLICY_VIEW,
                SystemPermission::LEAVE_POLICY_VIEW,
            ],
            SystemRole::DEPARTMENT_ADMIN->value => [
                // Attendance, leave, worklog within their department only
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::ATTENDANCE_EDIT,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_POLICY_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::LEAVES_EDIT,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::LEAVES_EXPORT,
                SystemPermission::LEAVE_POLICY_VIEW,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::WORKLOG_POLICY_VIEW,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::USERS_VIEW,
            ],
            SystemRole::MANAGER->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::USERS_VIEW,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
            ],
            SystemRole::TEAM_LEAD->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
            ],
            SystemRole::EMPLOYEE->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            SystemRole::INTERN->value => [
                // Same as employee but no leave balance-related permissions
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            SystemRole::CONTRACTOR->value => [
                // Clock in/out, submit worklog. No leave. No policy access.
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            SystemRole::VIEWER->value => [
                // Read-only on all modules they are given access to
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::USERS_VIEW,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::BRANCHES_VIEW,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::ATTENDANCE_POLICY_VIEW,
                SystemPermission::LEAVE_POLICY_VIEW,
                SystemPermission::WORKLOG_POLICY_VIEW,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allRoles = SystemRole::cases();
        $totalAssignments = 0;

        foreach ($allRoles as $systemRole) {
            $role = Role::where('name', $systemRole->value)
                ->where('guard_name', 'api')
                ->whereNull('organization_id')
                ->first();

            if (! $role) {
                $this->command->warn("System role '{$systemRole->value}' not found in database. Skipping.");

                continue;
            }

            $map = $this->rolePermissionMap();
            if (! array_key_exists($systemRole->value, $map)) {
                continue;
            }

            $mapping = $map[$systemRole->value];

            if ($mapping === null) {
                // Wildcard: assign ALL permissions for this guard
                $permissions = Permission::where('guard_name', $role->guard_name)->get();
            } else {
                // Map enum cases to permission name strings
                $permissionNames = array_map(fn (SystemPermission $p) => $p->value, $mapping);
                $permissions = Permission::whereIn('name', $permissionNames)
                    ->where('guard_name', $role->guard_name)
                    ->get();
            }

            $role->syncPermissions($permissions);
            $totalAssignments += $permissions->count();

            $this->command->info("Synced {$permissions->count()} permissions to role: {$role->name}");
        }

        $this->command->info("Total: Seeded {$totalAssignments} role-permission assignments via Spatie.");
    }
}
