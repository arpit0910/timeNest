<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rbac\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all platform permissions using {module}.{action} pattern.
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
        'corporations'  => ['manage'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $batch = [];

        foreach (self::PERMISSIONS as $module => $actions) {
            foreach ($actions as $action) {
                $name = "{$module}.{$action}";
                $batch[] = [
                    'uuid'        => (string) Str::uuid(),
                    'name'        => $name,
                    'module'      => $module,
                    'action'      => $action,
                    'description' => ucfirst($action) . ' ' . $module,
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        Permission::insert($batch);

        $this->command->info('Seeded ' . count($batch) . ' permissions.');
    }
}
