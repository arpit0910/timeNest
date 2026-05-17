<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Models\Rbac\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds all system permissions using the SystemPermission enum.
 *
 * Every permission in the system is defined as a typed enum case.
 * This seeder iterates over all enum cases — zero hardcoded strings.
 */
class PlatformPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = SystemPermission::cases();
        $count = 0;

        foreach ($cases as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission->value, 'guard_name' => 'api'],
                [
                    'uuid' => (string) Str::uuid(),
                    'module' => $permission->module(),
                    'action' => $permission->action(),
                    'description' => $permission->description(),
                ]
            );
            $count++;
        }

        $this->command->info("Seeded {$count} permissions (from SystemPermission enum).");
    }
}
