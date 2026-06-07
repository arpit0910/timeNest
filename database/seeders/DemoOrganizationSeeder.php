<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Organization\Branch;
use App\Models\Organization\Organization;
use App\Models\Organization\Department;
use App\Models\Geo\Country;
use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Seeds a demo organization with branches, departments, and sample users.
 *
 * Only runs in non-production environments.
 */
class DemoOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->warn('Skipping demo data in production.');

            return;
        }

        DB::transaction(function () {
            $india = Country::where('iso2', 'IN')->first();

            // Create demo organization
            $org = Organization::create([
                'uuid' => (string) Str::uuid(),
                'legal_name' => 'Acme Technologies Private Limited',
                'trading_name' => 'AcmeTech',
                'slug' => 'acme-tech',
                'legal_entity_type' => 'Private Limited',
                'industry' => 'Technology',
                'company_size' => '51-200',
                'email' => 'admin@acmetech.example.com',
                'phone' => '+919876543210',
                'timezone' => 'Asia/Kolkata',
                'locale' => 'en',
                'currency_code' => 'INR',
                'plan' => 'professional',
                'max_users' => 100,
                'country_id' => $india?->id,
                'is_active' => true,
                'is_verified' => true,
                'verified_at' => now(),
            ]);

            // Create HQ branch
            $hqBranch = Branch::create([
                'uuid' => (string) Str::uuid(),
                'organization_id' => $org->id,
                'name' => 'Mumbai Headquarters',
                'code' => 'MUM-HQ',
                'is_headquarters' => true,
                'timezone' => 'Asia/Kolkata',
                'country_id' => $india?->id,
                'is_active' => true,
            ]);

            // Create departments
            $engDept = Department::create([
                'uuid' => (string) Str::uuid(),
                'organization_id' => $org->id,
                'name' => 'Engineering',
                'code' => 'ENG',
                'is_active' => true,
            ]);

            Department::create([
                'uuid' => (string) Str::uuid(),
                'organization_id' => $org->id,
                'name' => 'Human Resources',
                'code' => 'HR',
                'is_active' => true,
            ]);

            // Create demo users with memberships
            // Use platform roles (organization_id = null), scope via team permissions
            $ownerRole = Role::where('name', SystemRole::OrganizationOwner->value)->whereNull('organization_id')->first();
            $employeeRole = Role::where('name', SystemRole::Employee->value)->whereNull('organization_id')->first();

            $password = Hash::make('Demo@1234');

            // Organization owner
            $owner = User::create([
                'uuid' => (string) Str::uuid(),
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh@acmetech.example.com',
                'password' => $password,
                'password_set' => true,
                'email_verified_at' => now(),
                'phone' => '+919876543211',
                'timezone' => 'Asia/Kolkata',
                'is_active' => true,
            ]);

            $ownerMembership = OrganizationMembership::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $owner->id,
                'organization_id' => $org->id,
                'status' => MembershipStatus::Active,
                'joined_at' => now(),
            ]);

            setPermissionsTeamId($org->id);
            $owner->assignRole($ownerRole);

            EmployeeProfile::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $owner->id,
                'organization_id' => $org->id,
                'organization_membership_id' => $ownerMembership->id,
                'employee_code' => 'EMP-001',
                'designation' => 'CEO & Founder',
                'department_id' => $engDept->id,
                'branch_id' => $hqBranch->id,
                'employment_type' => 'full_time',
                'joining_date' => '2024-01-01',
                'is_active' => true,
            ]);

            // Demo employee
            $emp = User::create([
                'uuid' => (string) Str::uuid(),
                'name' => 'Priya Sharma',
                'email' => 'priya@acmetech.example.com',
                'password' => $password,
                'password_set' => true,
                'email_verified_at' => now(),
                'timezone' => 'Asia/Kolkata',
                'is_active' => true,
            ]);

            $empMembership = OrganizationMembership::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $emp->id,
                'organization_id' => $org->id,
                'status' => MembershipStatus::Active,
                'invited_by' => $owner->id,
                'joined_at' => now(),
            ]);

            $emp->assignRole($employeeRole);

            EmployeeProfile::create([
                'uuid' => (string) Str::uuid(),
                'user_id' => $emp->id,
                'organization_id' => $org->id,
                'organization_membership_id' => $empMembership->id,
                'employee_code' => 'EMP-002',
                'designation' => 'Software Engineer',
                'department_id' => $engDept->id,
                'branch_id' => $hqBranch->id,
                'employment_type' => 'full_time',
                'joining_date' => '2024-03-15',
                'reports_to' => $owner->id,
                'is_active' => true,
            ]);
        });

        $this->command->info('Seeded demo organization with branches, departments, and users.');
    }
}
