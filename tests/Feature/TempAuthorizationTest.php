<?php

namespace Tests\Feature;

use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Organization\Organization;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TempAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_authorization_rules()
    {
        $org = Organization::create([
            'legal_name' => 'Test Org',
            'slug' => 'test-org-' . uniqid(),
            'is_active' => true,
        ]);
        
        $managerUser = User::factory()->create();
        $employeeUser = User::factory()->create();
        $otherEmployeeUser = User::factory()->create();
        $orgAdminUser = User::factory()->create();
        
        // Setup permissions
        $employeeRole = Role::firstOrCreate(['name' => 'employee', 'organization_id' => $org->id, 'guard_name' => 'api']);
        $employeeRole->givePermissionTo(SystemPermission::LEAVES_VIEW->value, SystemPermission::LEAVES_CREATE->value);

        $managerRole = Role::firstOrCreate(['name' => 'manager', 'organization_id' => $org->id, 'guard_name' => 'api']);
        $managerRole->givePermissionTo(SystemPermission::LEAVES_VIEW->value, SystemPermission::LEAVES_APPROVE->value);

        $orgAdminRole = Role::firstOrCreate(['name' => 'admin', 'organization_id' => $org->id, 'guard_name' => 'api']);
        $orgAdminRole->givePermissionTo(SystemPermission::LEAVES_VIEW->value, SystemPermission::LEAVES_APPROVE_ANY->value);

        setPermissionsTeamId($org->id);
        $employeeUser->assignRole($employeeRole);
        $otherEmployeeUser->assignRole($employeeRole);
        $managerUser->assignRole($managerRole);
        $orgAdminUser->assignRole($orgAdminRole);
        setPermissionsTeamId(null);

        // Setup organization memberships first
        $managerMembership = \App\Models\Organization\OrganizationMembership::create([
            'user_id' => $managerUser->id,
            'organization_id' => $org->id,
            'status' => \App\Enums\MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);
        $employeeMembership = \App\Models\Organization\OrganizationMembership::create([
            'user_id' => $employeeUser->id,
            'organization_id' => $org->id,
            'status' => \App\Enums\MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);
        $otherEmployeeMembership = \App\Models\Organization\OrganizationMembership::create([
            'user_id' => $otherEmployeeUser->id,
            'organization_id' => $org->id,
            'status' => \App\Enums\MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        // Setup profiles for hierarchy
        EmployeeProfile::create(['user_id' => $managerUser->id, 'organization_id' => $org->id, 'organization_membership_id' => $managerMembership->id, 'is_active' => true]);
        EmployeeProfile::create(['user_id' => $employeeUser->id, 'organization_id' => $org->id, 'organization_membership_id' => $employeeMembership->id, 'reports_to' => $managerUser->id, 'is_active' => true]);
        EmployeeProfile::create(['user_id' => $otherEmployeeUser->id, 'organization_id' => $org->id, 'organization_membership_id' => $otherEmployeeMembership->id, 'is_active' => true]); // does not report to manager

        // Dummy leave for employee
        $employeeLeave = EmployeeLeave::create([
            'user_id' => $employeeUser->id,
            'organization_id' => $org->id,
            'leave_type' => \App\Enums\Leave\LeaveType::SICK,
            'leave_status' => \App\Enums\Leave\LeaveStatus::PENDING,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
        ]);
        // Dummy leave for other employee
        $otherLeave = EmployeeLeave::create([
            'user_id' => $otherEmployeeUser->id,
            'organization_id' => $org->id,
            'leave_type' => \App\Enums\Leave\LeaveType::SICK,
            'leave_status' => \App\Enums\Leave\LeaveStatus::PENDING,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
        ]);
        // Dummy leave for manager (to test self-approval)
        $managerLeave = EmployeeLeave::create([
            'user_id' => $managerUser->id,
            'organization_id' => $org->id,
            'leave_type' => \App\Enums\Leave\LeaveType::SICK,
            'leave_status' => \App\Enums\Leave\LeaveStatus::PENDING,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
        ]);
        // Dummy leave for org admin (to test self-approval with approve_any)
        $adminLeave = EmployeeLeave::create([
            'user_id' => $orgAdminUser->id,
            'organization_id' => $org->id,
            'leave_type' => \App\Enums\Leave\LeaveType::SICK,
            'leave_status' => \App\Enums\Leave\LeaveStatus::PENDING,
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
        ]);

        // Helper to mimic app('tenant.organization') resolution during test
        $this->app->instance('tenant.organization', $org);
        
        echo "\n\n--- RUNNING POSTMAN HTTP TESTS ---\n";

        // Rule 5: Employee blocked from policy update
        // We use PUT /api/v1/organization/attendance/policy
        $response = $this->actingAs($employeeUser)->putJson('/api/v1/organization/attendance/policy', []);
        echo "Rule 5 (Employee updating policy): " . $response->status() . "\n";

        // Rule 6: Manager blocked from a non-report's leave
        $response = $this->actingAs($managerUser)->patchJson("/api/v1/organization/attendance/leaves/{$otherLeave->uuid}/status", ['status' => 2]);
        echo "Rule 6 (Manager approving non-report): " . $response->status() . "\n";

        // Rule 7: Manager allowed on their own report
        $response = $this->actingAs($managerUser)->patchJson("/api/v1/organization/attendance/leaves/{$employeeLeave->uuid}/status", ['status' => 2]);
        echo "Rule 7 (Manager approving direct report): " . $response->status() . "\n";

        // Rule 8: OrgAdmin bypass via approve_any (approving the regular employee's leave)
        $response = $this->actingAs($orgAdminUser)->patchJson("/api/v1/organization/attendance/leaves/{$employeeLeave->uuid}/status", ['status' => 2]);
        echo "Rule 8 (OrgAdmin approving anyone's leave via approve_any): " . $response->status() . "\n";

        // Rule 9a: Manager blocked from self-approval
        $response = $this->actingAs($managerUser)->patchJson("/api/v1/organization/attendance/leaves/{$managerLeave->uuid}/status", ['status' => 2]);
        echo "Rule 9a (Manager self-approving): " . $response->status() . "\n";
        
        // Rule 9b: OrgAdmin blocked from self-approval despite having approve_any
        $response = $this->actingAs($orgAdminUser)->patchJson("/api/v1/organization/attendance/leaves/{$adminLeave->uuid}/status", ['status' => 2]);
        echo "Rule 9b (OrgAdmin self-approving with approve_any): " . $response->status() . "\n";

        echo "----------------------------------\n\n";
    }
}
