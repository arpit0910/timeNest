<?php

namespace Tests\Feature;

use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Organization\Organization;
use App\Models\Membership\EmployeeProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TempAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        // Just in case permissions aren't seeded in the testing DB
        $this->artisan('db:seed', ['--class' => 'PlatformPermissionsSeeder']);
    }

    public function test_authorization_rules()
    {
        $org = Organization::factory()->create();
        
        $managerUser = User::factory()->create();
        $employeeUser = User::factory()->create();
        $otherEmployeeUser = User::factory()->create();
        $orgAdminUser = User::factory()->create();
        
        // Setup permissions
        $employeeRole = Role::firstOrCreate(['name' => 'employee', 'organization_id' => $org->id, 'guard_name' => 'web']);
        $employeeRole->givePermissionTo(SystemPermission::LEAVES_VIEW->value, SystemPermission::LEAVES_CREATE->value);
        
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'organization_id' => $org->id, 'guard_name' => 'web']);
        $managerRole->givePermissionTo(SystemPermission::LEAVES_VIEW->value, SystemPermission::LEAVES_APPROVE->value);
        
        $orgAdminRole = Role::firstOrCreate(['name' => 'organization_admin', 'organization_id' => $org->id, 'guard_name' => 'web']);
        $orgAdminRole->givePermissionTo(SystemPermission::LEAVES_VIEW->value, SystemPermission::LEAVES_APPROVE_ANY->value);

        setPermissionsTeamId($org->id);
        $employeeUser->assignRole($employeeRole);
        $otherEmployeeUser->assignRole($employeeRole);
        $managerUser->assignRole($managerRole);
        $orgAdminUser->assignRole($orgAdminRole);
        setPermissionsTeamId(null);
        
        // Setup profiles for hierarchy
        EmployeeProfile::factory()->create(['user_id' => $managerUser->id, 'organization_id' => $org->id]);
        EmployeeProfile::factory()->create(['user_id' => $employeeUser->id, 'organization_id' => $org->id, 'reports_to' => $managerUser->id]);
        EmployeeProfile::factory()->create(['user_id' => $otherEmployeeUser->id, 'organization_id' => $org->id]); // does not report to manager

        // Dummy leave for employee
        $employeeLeave = EmployeeLeave::factory()->create(['user_id' => $employeeUser->id, 'organization_id' => $org->id, 'status' => 1]);
        // Dummy leave for other employee
        $otherLeave = EmployeeLeave::factory()->create(['user_id' => $otherEmployeeUser->id, 'organization_id' => $org->id, 'status' => 1]);
        // Dummy leave for manager (to test self-approval)
        $managerLeave = EmployeeLeave::factory()->create(['user_id' => $managerUser->id, 'organization_id' => $org->id, 'status' => 1]);
        // Dummy leave for org admin (to test self-approval with approve_any)
        $adminLeave = EmployeeLeave::factory()->create(['user_id' => $orgAdminUser->id, 'organization_id' => $org->id, 'status' => 1]);

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
