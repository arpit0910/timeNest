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
            SystemRole::APP_SUPER_ADMIN->value => [
                SystemPermission::PLATFORM_FULL_ACCESS,
            ],
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

            // No organization-tier role is defined here. Both seeders call the
            // destructive syncPermissions(), so any role declared in both had its
            // final permissions decided by whichever ran last.
            //
            // super_admin was the last such duplicate. Both mapped it to null, but
            // the wildcards resolve differently — this seeder's grants every
            // permission for the guard (101, including platform.*), while
            // OrganizationRolePermissionsSeeder excludes the platform plane (98).
            // Identical declarations, different results.
            //
            // OrganizationRolePermissionsSeeder is now the sole definition for
            // every organization-tier role.
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
