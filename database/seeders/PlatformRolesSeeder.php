<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemRole;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all system roles — platform guard and corporation guard.
 *
 * System roles: is_system_role=true, corporation_id=null.
 * Cannot be deleted or renamed by anyone.
 *
 * All role names are derived from the SystemRole enum — zero hardcoded strings.
 */
class PlatformRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allRoles = SystemRole::cases();

        foreach ($allRoles as $systemRole) {
            Role::firstOrCreate(
                [
                    'name' => $systemRole->value,
                    'guard_name' => 'api',
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'corporation_id' => null,
                    'description' => $systemRole->description(),
                    'is_system_role' => true,
                    'sort_order' => $systemRole->sortOrder(),
                ]
            );
        }

        $this->command->info('Seeded '.count($allRoles).' system roles (from SystemRole enum).');
    }
}
