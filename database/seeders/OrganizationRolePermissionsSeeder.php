<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;

/**
 * Seeds permissions for organization-scoped roles.
 *
 * This seeder runs AFTER DemoOrganizationSeeder to assign permissions
 * to roles within each organization context.
 *
 * Uses the same permission map as PlatformRolePermissionsSeeder,
 * but applies it to organization-scoped roles.
 */
class OrganizationRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping for org-level roles.
     *
     * @return array<string, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // Org-wide administration
            SystemRole::DIRECTOR->value    => null, // ALL permissions
            SystemRole::SUPER_ADMIN->value => null, // ALL permissions (billing excluded at app layer)
            SystemRole::ADMIN->value       => [
                SystemPermission::USERS_VIEW,
                SystemPermission::USERS_INVITE,
                SystemPermission::USERS_EDIT,
                SystemPermission::USERS_DELETE,
                SystemPermission::USERS_MANAGE,
                SystemPermission::USERS_EXPORT,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_MANAGE,
                SystemPermission::ROLES_VIEW,
                SystemPermission::ROLES_CREATE,
                SystemPermission::ROLES_EDIT,
                SystemPermission::ROLES_DELETE,
                SystemPermission::ROLES_ASSIGN_PERMISSIONS,
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
                SystemPermission::SUB_DEPARTMENTS_VIEW,
                SystemPermission::SUB_DEPARTMENTS_CREATE,
                SystemPermission::SUB_DEPARTMENTS_EDIT,
                SystemPermission::SUB_DEPARTMENTS_DELETE,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::DESIGNATIONS_CREATE,
                SystemPermission::DESIGNATIONS_EDIT,
                SystemPermission::DESIGNATIONS_DELETE,
                SystemPermission::MEMBERS_ASSIGN_DESIGNATION,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::DEPARTMENTS_ASSIGN_HEAD,
                SystemPermission::SUB_DEPARTMENTS_ASSIGN_HEAD,
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
            // Department-scoped authority
            SystemRole::HEAD->value => [
                SystemPermission::USERS_VIEW,
                SystemPermission::USERS_INVITE,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_MANAGE,
                SystemPermission::ROLES_VIEW,
                SystemPermission::ROLES_CREATE,
                SystemPermission::ROLES_EDIT,
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
                SystemPermission::SUB_DEPARTMENTS_VIEW,
                SystemPermission::SUB_DEPARTMENTS_CREATE,
                SystemPermission::SUB_DEPARTMENTS_EDIT,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::DESIGNATIONS_CREATE,
                SystemPermission::DESIGNATIONS_EDIT,
                SystemPermission::MEMBERS_ASSIGN_DESIGNATION,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::DEPARTMENTS_ASSIGN_HEAD,
                SystemPermission::SUB_DEPARTMENTS_ASSIGN_HEAD,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::WORKLOG_APPROVE_ANY,
                SystemPermission::WORKLOG_POLICY_VIEW,
                SystemPermission::LEAVE_POLICY_VIEW,
            ],
            SystemRole::DEPARTMENT_ADMIN->value => [
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
                SystemPermission::SUB_DEPARTMENTS_VIEW,
                SystemPermission::SUB_DEPARTMENTS_CREATE,
                SystemPermission::SUB_DEPARTMENTS_EDIT,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::DESIGNATIONS_CREATE,
                SystemPermission::DESIGNATIONS_EDIT,
                SystemPermission::MEMBERS_ASSIGN_DESIGNATION,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::DEPARTMENTS_ASSIGN_HEAD,
                SystemPermission::SUB_DEPARTMENTS_ASSIGN_HEAD,
                SystemPermission::USERS_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_MANAGE,
            ],
            // Generic management
            SystemRole::MANAGER->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::USERS_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_MANAGE,
                SystemPermission::ROLES_VIEW,
                SystemPermission::SUB_DEPARTMENTS_VIEW,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
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
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::ROLES_VIEW,
                SystemPermission::SUB_DEPARTMENTS_VIEW,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
            ],
            // Workers
            SystemRole::EMPLOYEE->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::ROLES_VIEW,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            SystemRole::INTERN->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            SystemRole::CONTRACTOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            // Observers
            SystemRole::VIEWER->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::USERS_VIEW,
                SystemPermission::EMPLOYEE_PROFILE_VIEW,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::BRANCHES_VIEW,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::DESIGNATIONS_VIEW,
                SystemPermission::MEMBERS_VIEW_HIERARCHY,
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
        $map = $this->rolePermissionMap();
        $totalAssignments = 0;

        foreach ($map as $roleName => $permissions) {
            // Find or create the global role
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'api',
                'organization_id' => null,
            ]);

            if ($permissions === null) {
                // Wildcard: assign ALL permissions for this guard
                $perms = Permission::where('guard_name', $role->guard_name)->get();
            } else {
                // Map enum cases to permission name strings
                $permissionNames = array_map(fn (SystemPermission $p) => $p->value, $permissions);
                $perms = Permission::whereIn('name', $permissionNames)
                    ->where('guard_name', $role->guard_name)
                    ->get();
            }

            $role->syncPermissions($perms);
            $totalAssignments += $perms->count();

            $this->command->info("Synced {$perms->count()} permissions to role: {$role->name}");
        }

        $this->command->info("Total: Seeded {$totalAssignments} role-permission assignments for global org roles.");
    }
}
