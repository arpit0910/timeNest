<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rbac\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all platform permissions using {module}.{action} pattern for Spatie.
 */
class PlatformPermissionsSeeder extends Seeder
{
    /**
     * Permission definitions organized by module.
     */
    private const PERMISSIONS = [
        'attendance'    => ['view', 'create', 'edit', 'delete', 'approve', 'export', 'import'],
        'users'         => ['view', 'invite', 'edit', 'delete', 'manage', 'export'],
        'payroll'       => ['view', 'create', 'edit', 'delete', 'export', 'approve', 'process'],
        'hrms'          => ['view', 'create', 'edit', 'delete', 'export'],
        'leaves'        => ['view', 'create', 'edit', 'delete', 'approve', 'export'],
        'branches'      => ['view', 'create', 'edit', 'delete', 'manage'],
        'departments'   => ['view', 'create', 'edit', 'delete', 'manage'],
        'reports'       => ['view', 'export', 'schedule'],
        'settings'      => ['manage'],
        'invoicing'     => ['view', 'create', 'edit', 'delete', 'send', 'approve'],
        'workflows'     => ['view', 'create', 'edit', 'delete', 'trigger'],
    ];

    private const PLATFORM_PERMISSIONS = [
        'corporations'  => ['manage'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $count = 0;

        foreach (self::PERMISSIONS as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$module}.{$action}", 'guard_name' => 'api'],
                    [
                        'uuid'        => (string) Str::uuid(),
                        'module'      => $module,
                        'action'      => $action,
                        'description' => ucfirst($action) . ' ' . $module,
                    ]
                );
                $count++;
            }
        }

        foreach (self::PLATFORM_PERMISSIONS as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$module}.{$action}", 'guard_name' => 'api'],
                    [
                        'uuid'        => (string) Str::uuid(),
                        'module'      => $module,
                        'action'      => $action,
                        'description' => ucfirst($action) . ' ' . $module,
                    ]
                );
                $count++;
            }
        }

        $this->command->info('Seeded ' . $count . ' permissions.');
    }
}
