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
     * @return array<SystemRole, SystemPermission[]|null>
     */
    private function rolePermissionMap(): array
    {
        return [
            // Platform roles
            SystemRole::APP_OWNER->value => null, // ALL permissions
            SystemRole::APP_SUPER_ADMIN->value => null, // ALL permissions
            SystemRole::APP_ADMIN->value => [
                SystemPermission::ORGANIZATIONS_MANAGE,
                SystemPermission::USERS_VIEW,
                SystemPermission::USERS_EDIT,
                SystemPermission::USERS_MANAGE,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::ATTENDANCE_VIEW,
            ],
            SystemRole::SUPPORT_AGENT->value => [
                SystemPermission::USERS_VIEW,
                SystemPermission::REPORTS_VIEW,
            ],
            SystemRole::AUDITOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_EXPORT,
                SystemPermission::USERS_VIEW,
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

            // Organization roles
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
            ],
            SystemRole::MANAGER->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_APPROVE,
                SystemPermission::REPORTS_VIEW,
                SystemPermission::USERS_VIEW,
            ],
            SystemRole::SUPERVISOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::ATTENDANCE_APPROVE,
            ],
            SystemRole::EMPLOYEE->value => [
                SystemPermission::ATTENDANCE_VIEW,
                SystemPermission::LEAVES_VIEW,
                SystemPermission::LEAVES_CREATE,
            ],
            SystemRole::CONTRACTOR->value => [
                SystemPermission::ATTENDANCE_VIEW,
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

            if ($mapping === 'skip') {
                continue;
            }

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
