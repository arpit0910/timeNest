<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all system roles — platform guard and corporation guard.
 *
 * System roles: is_system_role=true, corporation_id=null.
 * Cannot be deleted or renamed by anyone.
 */
class PlatformRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $platformRoles = [
            ['name' => 'app_owner',       'guard_name' => 'api', 'description' => 'Absolute platform owner. No restrictions.', 'sort_order' => 1],
            ['name' => 'app_super_admin', 'guard_name' => 'api', 'description' => 'Platform super admin. Manages corporations, billing, platform config.', 'sort_order' => 2],
            ['name' => 'app_admin',       'guard_name' => 'api', 'description' => 'Platform admin. Daily operations, support escalations.', 'sort_order' => 3],
            ['name' => 'support_agent',   'guard_name' => 'api', 'description' => 'Read-only access to corporation data for support.', 'sort_order' => 4],
            ['name' => 'auditor',         'guard_name' => 'api', 'description' => 'Read-only audit access across platform.', 'sort_order' => 5],
        ];

        $corpRoles = [
            ['name' => 'corporation_owner',       'guard_name' => 'api', 'description' => 'Absolute owner of the corporation. Cannot be revoked by corp admins.', 'sort_order' => 1],
            ['name' => 'corporation_super_admin', 'guard_name' => 'api', 'description' => 'Full corp access. Can manage all settings, users, billing.', 'sort_order' => 2],
            ['name' => 'corporation_admin',       'guard_name' => 'api', 'description' => 'Operational admin. Users, attendance, reports. Cannot touch billing.', 'sort_order' => 3],
            ['name' => 'hr_manager',              'guard_name' => 'api', 'description' => 'HR operations: employee records, leave, attendance, onboarding.', 'sort_order' => 4],
            ['name' => 'manager',                 'guard_name' => 'api', 'description' => 'Team-level management. Approve leaves and attendance for team.', 'sort_order' => 5],
            ['name' => 'supervisor',              'guard_name' => 'api', 'description' => 'Limited oversight. Attendance review only.', 'sort_order' => 6],
            ['name' => 'employee',                'guard_name' => 'api', 'description' => 'Standard self-service access.', 'sort_order' => 7],
            ['name' => 'contractor',              'guard_name' => 'api', 'description' => 'Project-scoped, limited access.', 'sort_order' => 8],
        ];

        $allRoles = array_merge($platformRoles, $corpRoles);

        foreach ($allRoles as $roleData) {
            Role::firstOrCreate(
                [
                    'name'       => $roleData['name'],
                    'guard_name' => $roleData['guard_name'],
                ],
                [
                    'uuid'           => (string) Str::uuid(),
                    'corporation_id' => null,
                    'description'    => $roleData['description'],
                    'is_system_role' => true,
                    'sort_order'     => $roleData['sort_order'],
                ]
            );
        }

        $this->command->info('Seeded ' . count($allRoles) . ' system roles.');
    }
}
