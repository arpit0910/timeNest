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
     * Role → permission mapping (same as PlatformRolePermissionsSeeder).
     *
     * @return array<SystemRole, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // Organization roles only
            SystemRole::ORGANIZATION_OWNER->value => null, // ALL permissions
            SystemRole::ORGANIZATION_SUPER_ADMIN->value => null, // ALL permissions
            SystemRole::ORGANIZATION_ADMIN->value => [
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
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::ATTENDANCE_IMPORT,
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
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::LEAVES_APPROVE_ANY,
                SystemPermission::ATTENDANCE_APPROVE_ANY,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_POLICY_VIEW,
                SystemPermission::ATTENDANCE_POLICY_MANAGE,
                SystemPermission::LEAVE_POLICY_VIEW,
                SystemPermission::LEAVE_POLICY_MANAGE,
                SystemPermission::WORKLOG_POLICY_VIEW,
                SystemPermission::WORKLOG_POLICY_MANAGE,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
            ],
            SystemRole::HR_MANAGER->value => [
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
                SystemPermission::LEAVES_EXPORT,
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::ATTENDANCE_EDIT,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::DEPARTMENTS_VIEW,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::WORKLOG_APPROVE_ANY,
                SystemPermission::LEAVES_APPROVE_ANY,
                SystemPermission::ATTENDANCE_APPROVE_ANY,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_POLICY_VIEW,
                SystemPermission::LEAVE_POLICY_VIEW,
                SystemPermission::WORKLOG_POLICY_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
            ],
            SystemRole::MANAGER->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::USERS_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::WORKLOG_APPROVE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE,
            ],
            SystemRole::SUPERVISOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ESCALATIONS_VIEW,
            ],
            SystemRole::EMPLOYEE->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
            SystemRole::CONTRACTOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_CREATE,
                SystemPermission::WORKLOG_VIEW,
                SystemPermission::WORKLOG_CREATE,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_VIEW,
                SystemPermission::ATTENDANCE_ADJUSTMENTS_CREATE,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all organizations
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            $this->seedPermissionsForOrganization($organization);
        }
    }

    /**
     * Seed permissions for a specific organization.
     */
    private function seedPermissionsForOrganization(Organization $organization): void
    {
        $map = $this->rolePermissionMap();
        $totalAssignments = 0;

        foreach ($map as $roleName => $permissions) {
            // Find the organization-scoped role
            $role = Role::where('name', $roleName)
                ->where('organization_id', $organization->id)
                ->first();

            if (! $role) {
                continue;
            }

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

            $this->command->info("Synced {$perms->count()} permissions to role: {$role->name} in organization: {$organization->legal_name}");
        }

        $this->command->info("Total: Seeded {$totalAssignments} role-permission assignments for organization: {$organization->legal_name}");
    }
}
