<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemRole;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all system roles — platform guard and organization guard.
 *
 * System roles: is_system_role=true, organization_id=null.
 * Cannot be deleted or renamed by anyone.
 *
 * All role names are derived from the SystemRole enum — zero hardcoded strings.
 *
 * Also cleans up stale roles from previous role architectures.
 */
class PlatformRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Delete stale roles from previous architecture
        $this->deleteStaleRoles();

        // 2. Seed current roles from enum
        $allRoles = SystemRole::cases();

        foreach ($allRoles as $systemRole) {
            Role::firstOrCreate(
                [
                    'name' => $systemRole->value,
                    'guard_name' => 'api',
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'organization_id' => null,
                    'description' => $systemRole->description(),
                    'is_system_role' => true,
                    'sort_order' => $systemRole->sortOrder(),
                ]
            );
        }

        $this->command->info('Seeded '.count($allRoles).' system roles (from SystemRole enum).');
    }

    /**
     * Remove roles from previous architecture that no longer exist in the enum.
     */
    private function deleteStaleRoles(): void
    {
        $staleRoleNames = [
            // Old platform role slugs
            'app_owner',
            'support_agent',
            'auditor',
            // Old org-level role slugs
            'organization_owner',
            'organization_super_admin',
            'organization_admin',
            'hr_manager',
            'supervisor',
            // Department-specific roles that should never have been roles
            'hr_admin',
            'sales_admin',
            'finance_admin',
            'hr_head',
            'sales_head',
            'finance_head',
            'operations_head',
            'it_head',
        ];

        $deleted = Role::whereIn('name', $staleRoleNames)
            ->whereNull('organization_id')
            ->where('is_system_role', true)
            ->delete();

        // Also delete org-scoped copies of stale roles
        $deletedOrgScoped = Role::whereIn('name', $staleRoleNames)->delete();

        if ($deleted > 0 || $deletedOrgScoped > 0) {
            $this->command->info("Cleaned up " . ($deleted + $deletedOrgScoped) . " stale roles from previous architecture.");
        }
    }
}
