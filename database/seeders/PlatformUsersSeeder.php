<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\Membership\PlatformMembership;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Creates initial platform admin users.
 *
 * These users can access the platform admin panel immediately.
 * Passwords should be force-changed on first login in production.
 */
class PlatformUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->warn('Skipping platform seed users in production.');

            return;
        }

        $platformUsers = [
            [
                'name' => 'TimeNest Owner',
                'email' => 'app.owner@timenest.internal',
                'role' => 'app_owner',
            ],
            [
                'name' => 'TimeNest Super Admin',
                'email' => 'app.superadmin@timenest.internal',
                'role' => 'app_super_admin',
            ],
            [
                'name' => 'TimeNest Admin',
                'email' => 'app.admin@timenest.internal',
                'role' => 'app_admin',
            ],
        ];

        $password = Hash::make((string) env('TIMENEST_PLATFORM_SEED_PASSWORD', 'TimeNest@Owner#1'));

        foreach ($platformUsers as $userData) {
            $role = Role::where('name', $userData['role'])
                ->whereNull('organization_id')
                ->firstOrFail();

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'uuid' => (string) Str::uuid(),
                    'name' => $userData['name'],
                    'password' => $password,
                    'password_set' => true,
                    'email_verified_at' => now(),
                    'timezone' => 'UTC',
                    'locale' => 'en',
                    'is_active' => true,
                    'token_version' => 1,
                ]
            );

            PlatformMembership::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'uuid' => (string) Str::uuid(),
                    'status' => 'active',
                    'granted_by' => null,
                ]
            );

            // Assign Spatie platform role
            $user->assignRole($role);
        }

        $this->command->info('Seeded '.count($platformUsers).' platform admin users.');
    }
}
