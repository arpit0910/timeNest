<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Master database seeder — orchestrates all seeders in correct dependency order.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Geo data (no dependencies)
            CountrySeeder::class,
            StateSeeder::class,

            // 2. RBAC foundation
            PlatformPermissionsSeeder::class,
            PlatformRolesSeeder::class,
            PlatformRolePermissionsSeeder::class,

            // 3. Platform users
            PlatformUsersSeeder::class,

            // 4. Demo data (dev only)
            DemoOrganizationSeeder::class,
            OrganizationRolePermissionsSeeder::class,
            RealisticOrganizationsSeeder::class,
        ]);
    }
}
