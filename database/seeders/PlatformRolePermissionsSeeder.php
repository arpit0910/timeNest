<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use App\Models\Rbac\RolePermission;
use Illuminate\Database\Seeder;

/**
 * Maps permissions to system roles.
 *
 * Permission assignment per role as defined in the master prompt.
 */
class PlatformRolePermissionsSeeder extends Seeder
{
    /**
     * Role → permission mapping.
     * '*' means all permissions.
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
        $allPermissions = Permission::pluck('id', 'name');
        $allPermissionIds = $allPermissions->values()->toArray();
        $roles = Role::system()->get()->keyBy('name');

        $batch = [];

        foreach (self::ROLE_PERMISSIONS as $roleName => $permissionNames) {
            $role = $roles[$roleName] ?? null;
            if (!$role) {
                $this->command->warn("Role '{$roleName}' not found. Skipping.");
                continue;
            }

            $permIds = $permissionNames === ['*']
                ? $allPermissionIds
                : $allPermissions->only($permissionNames)->values()->toArray();

            foreach ($permIds as $permId) {
                $batch[] = [
                    'role_id'       => $role->id,
                    'permission_id' => $permId,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
        }

        foreach (array_chunk($batch, 100) as $chunk) {
            RolePermission::insert($chunk);
        }

        $this->command->info('Seeded ' . count($batch) . ' role-permission mappings.');
    }
}
