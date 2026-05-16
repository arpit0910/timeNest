<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;

/**
 * Maps permissions to system roles using Spatie Laravel Permission.
 *
 * Permission assignment per role as defined in the master prompt.
 */
class PlatformRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping.
     * '*' means all permissions (scoped to the role's guard).
     */
    private const ROLE_PERMISSIONS = [
        // Platform roles
        'app_owner'       => ['*'],
        'app_super_admin' => ['*'],
        'app_admin'       => ['corporations.manage', 'users.view', 'users.edit', 'users.manage', 'reports.view', 'attendance.view'],
        'support_agent'   => ['users.view', 'reports.view'],
        'auditor'         => [
            'attendance.view', 'attendance.export',
            'users.view', 'users.export',
            'payroll.view', 'payroll.export',
            'hrms.view', 'hrms.export',
            'leaves.view', 'leaves.export',
            'branches.view', 'departments.view',
            'reports.view', 'reports.export',
        ],

        // Corporation roles
        'corporation_owner'       => ['*'],
        'corporation_super_admin' => ['*'],
        'corporation_admin'       => [
            'users.view', 'users.invite', 'users.edit', 'users.delete', 'users.manage', 'users.export',
            'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.delete', 'attendance.approve', 'attendance.export', 'attendance.import',
            'reports.view', 'reports.export',
            'branches.view', 'branches.create', 'branches.edit', 'branches.delete', 'branches.manage',
            'departments.view', 'departments.create', 'departments.edit', 'departments.delete', 'departments.manage',
            'settings.manage',
        ],
        'hr_manager' => [
            'users.view', 'users.invite',
            'hrms.view', 'hrms.create', 'hrms.edit', 'hrms.delete', 'hrms.export',
            'leaves.view', 'leaves.create', 'leaves.edit', 'leaves.delete', 'leaves.approve', 'leaves.export',
            'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.approve', 'attendance.export',
            'departments.view',
        ],
        'manager' => [
            'attendance.view', 'attendance.approve',
            'leaves.view', 'leaves.approve',
            'reports.view',
            'users.view',
        ],
        'supervisor' => [
            'attendance.view', 'attendance.approve',
        ],
        'employee' => [
            'attendance.view',
            'leaves.view', 'leaves.create',
        ],
        'contractor' => [
            'attendance.view',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Fetch all roles grouped by guard
        $roles = Role::where('is_system_role', true)->get();

        $count = 0;

        foreach ($roles as $role) {
            $permissionNames = self::ROLE_PERMISSIONS[$role->name] ?? null;

            if (!$permissionNames) {
                continue;
            }

            if ($permissionNames === ['*']) {
                // Get all permissions for this role's guard
                $permissions = Permission::where('guard_name', $role->guard_name)->get();
            } else {
                // Note: some roles might specify permissions that exist in the opposite guard.
                // But Spatie requires role guard and permission guard to match.
                // We'll map them strictly by name and role's guard.
                $permissions = Permission::whereIn('name', $permissionNames)
                                         ->where('guard_name', $role->guard_name)
                                         ->get();
            }

            $role->syncPermissions($permissions);
            $count += $permissions->count();
        }

        $this->command->info('Seeded ' . $count . ' role-permission assignments via Spatie.');
    }
}
