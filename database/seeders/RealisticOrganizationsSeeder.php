<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class RealisticOrganizationsSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->warn('Skipping test data in production.');
            return;
        }

        $faker = Faker::create();
        $password = Hash::make('Password@123');

        $orgRoles = [
            SystemRole::DIRECTOR->value,
            SystemRole::ADMIN->value,
            SystemRole::HEAD->value,
            SystemRole::MANAGER->value,
            SystemRole::EMPLOYEE->value,
        ];

        DB::transaction(function () use ($faker, $password, $orgRoles) {
            for ($i = 0; $i < 5; $i++) {
                $companyName = $faker->company;
                $domain = Str::slug($companyName) . '.com';

                $org = Organization::create([
                    'uuid' => (string) Str::uuid(),
                    'legal_name' => $companyName . ' ' . $faker->companySuffix,
                    'trading_name' => $companyName,
                    'slug' => Str::slug($companyName) . '-' . Str::random(4),
                    'legal_entity_type' => 'LLC',
                    'industry' => 'Technology',
                    'company_size' => '51-200',
                    'email' => 'contact@' . $domain,
                    'phone' => substr($faker->e164PhoneNumber, 0, 15),
                    'timezone' => 'America/New_York',
                    'locale' => 'en',
                    'currency_code' => 'USD',
                    'plan' => 'professional',
                    'max_users' => 100,
                    'is_active' => true,
                    'is_verified' => true,
                    'verified_at' => now(),
                ]);

                // Set team id for Spatie permissions to scope roles to this org
                setPermissionsTeamId($org->id);

                foreach ($orgRoles as $roleName) {
                    $role = Role::where('name', $roleName)->whereNull('organization_id')->first();
                    if (!$role) continue;

                    $firstName = $faker->firstName;
                    $lastName = $faker->lastName;
                    $emailPrefix = strtolower($firstName . '.' . $lastName);

                    $user = User::create([
                        'uuid' => (string) Str::uuid(),
                        'name' => $firstName . ' ' . $lastName,
                        'email' => $emailPrefix . '@' . $domain,
                        'password' => $password,
                        'password_set' => true,
                        'email_verified_at' => now(),
                        'phone' => substr($faker->e164PhoneNumber, 0, 15),
                        'timezone' => 'America/New_York',
                        'is_active' => true,
                    ]);

                    $membership = OrganizationMembership::create([
                        'uuid' => (string) Str::uuid(),
                        'user_id' => $user->id,
                        'organization_id' => $org->id,
                        'status' => MembershipStatus::ACTIVE,
                        'joined_at' => now(),
                    ]);

                    EmployeeProfile::create([
                        'uuid' => (string) Str::uuid(),
                        'user_id' => $user->id,
                        'organization_id' => $org->id,
                        'organization_membership_id' => $membership->id,
                        'employee_code' => strtoupper(Str::random(6)),
                        'employment_type' => 'full_time',
                        'joining_date' => $faker->date(),
                        'is_active' => true,
                    ]);

                    $user->assignRole($role);
                }
            }
        });

        $this->command->info('Seeded 5 realistic organizations with role-based users.');
    }
}
