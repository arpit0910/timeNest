<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Leave\ApprovalFlow;
use App\Enums\Leave\LeaveStatus;
use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Membership\EmployeeProfile;
use App\Models\Organization\Department;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use Database\Seeders\OrganizationRolePermissionsSeeder;
use Database\Seeders\PlatformPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveScopingPostmanTest extends TestCase
{
    use RefreshDatabase;

    public function test_approve_any_holder_manager_can_view_other_department_leave_requests(): void
    {
        $this->seed(PlatformPermissionsSeeder::class);
        $this->seed(OrganizationRolePermissionsSeeder::class);

        $org = Organization::create([
            'legal_name' => 'Acme Global',
            'slug' => 'acme-global-' . uniqid(),
            'is_active' => true,
        ]);

        $deptSales = Department::create([
            'organization_id' => $org->id,
            'name' => 'Sales Department',
            'code' => 'SALES',
        ]);

        $deptEng = Department::create([
            'organization_id' => $org->id,
            'name' => 'Engineering Department',
            'code' => 'ENG',
        ]);

        // Manager in Sales holding LEAVES_APPROVE_ANY
        $managerApproveAny = User::factory()->create(['name' => 'Sales Manager (Approve Any)', 'email' => 'sales_mgr@acme.com']);
        // Manager in Eng holding only LEAVES_APPROVE
        $managerStandard = User::factory()->create(['name' => 'Eng Manager (Standard)', 'email' => 'eng_mgr@acme.com']);
        // Employee in Engineering
        $employeeEng = User::factory()->create(['name' => 'Eng Developer', 'email' => 'eng_dev@acme.com']);

        foreach ([$managerApproveAny, $managerStandard, $employeeEng] as $user) {
            OrganizationMembership::create([
                'user_id' => $user->id,
                'organization_id' => $org->id,
                'status' => \App\Enums\MembershipStatus::ACTIVE,
                'joined_at' => now(),
            ]);
        }

        EmployeeProfile::create([
            'user_id' => $managerApproveAny->id,
            'organization_id' => $org->id,
            'department_id' => $deptSales->id,
        ]);

        EmployeeProfile::create([
            'user_id' => $managerStandard->id,
            'organization_id' => $org->id,
            'department_id' => $deptEng->id,
        ]);

        EmployeeProfile::create([
            'user_id' => $employeeEng->id,
            'organization_id' => $org->id,
            'department_id' => $deptEng->id,
            'reports_to' => $managerStandard->id,
        ]);

        $memberRole = Role::where('name', SystemRole::FREELANCE_MEMBER->value)->firstOrFail();

        setPermissionsTeamId($org->id);
        $managerApproveAny->assignRole($memberRole);
        $managerApproveAny->givePermissionTo(SystemPermission::LEAVES_VIEW->value);
        $managerApproveAny->givePermissionTo(SystemPermission::LEAVES_APPROVE_ANY->value);

        $managerStandard->assignRole($memberRole);
        $managerStandard->givePermissionTo(SystemPermission::LEAVES_VIEW->value);
        $managerStandard->givePermissionTo(SystemPermission::LEAVES_APPROVE->value);

        $employeeEng->assignRole($memberRole);
        $employeeEng->givePermissionTo(SystemPermission::LEAVES_VIEW->value);
        $employeeEng->givePermissionTo(SystemPermission::LEAVES_CREATE->value);
        setPermissionsTeamId(null);

        $policy = LeavePolicy::create([
            'organization_id' => $org->id,
            'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
            'allow_half_day_leaves' => true,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'allow_leave_cancellation' => true,
            'created_by' => $managerApproveAny->id,
        ]);

        $policyVersion = LeavePolicyVersion::create([
            'leave_policy_id' => $policy->id,
            'organization_id' => $org->id,
            'version' => 1,
            'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'allow_half_day_leaves' => true,
            'created_by' => $managerApproveAny->id,
        ]);

        $leaveType = LeaveType::create([
            'organization_id' => $org->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Annual Leave',
            'is_active' => true,
            'code' => 1,
            'allow_half_day' => true,
            'annual_allocation_days' => 20,
            'created_by' => $managerApproveAny->id,
        ]);

        // Submit leave for Eng Developer
        $leaveEng = EmployeeLeave::create([
            'organization_id' => $org->id,
            'user_id' => $employeeEng->id,
            'leave_type' => \App\Enums\Leave\LeaveType::CASUAL_LEAVE,
            'leave_type_id' => $leaveType->id,
            'leave_policy_version_id' => $policyVersion->id,
            'approval_flow_snapshot' => ApprovalFlow::SINGLE_APPROVAL->value,
            'leave_status' => LeaveStatus::PENDING->value,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'total_days' => 3.0,
            'reason' => 'Engineering Conference Leave',
        ]);

        // TEST 1: Manager holding LEAVES_APPROVE_ANY in Sales views leave requests for the organization
        $responseApproveAny = $this->actingAs($managerApproveAny, 'api')
            ->withHeader('X-Organization-Id', (string) $org->id)
            ->getJson('/api/v1/leave-requests');

        echo "\n================ POSTMAN SIMULATION RESULTS ================\n";
        echo "[TEST 1] Manager with LEAVES_APPROVE_ANY (Sales Dept) viewing Eng Dev leave request:\n";
        echo "HTTP Status: " . $responseApproveAny->status() . "\n";
        echo "Response Data Count: " . count($responseApproveAny->json('data.data')) . "\n";
        echo "Returned User UUID: " . $responseApproveAny->json('data.data.0.user.uuid') . "\n";
        echo "Returned User Name: " . $responseApproveAny->json('data.data.0.user.name') . "\n";

        $responseApproveAny->assertStatus(200);
        $this->assertEquals($employeeEng->uuid, $responseApproveAny->json('data.data.0.user.uuid'));

        // TEST 2: Manager holding standard LEAVES_APPROVE in Eng views leave requests
        $responseStandard = $this->actingAs($managerStandard, 'api')
            ->withHeader('X-Organization-Id', (string) $org->id)
            ->getJson('/api/v1/leave-requests');

        echo "\n[TEST 2] Standard Manager in Eng (line manager of Eng Dev) viewing leave requests:\n";
        echo "HTTP Status: " . $responseStandard->status() . "\n";
        echo "Returned Count: " . count($responseStandard->json('data.data')) . "\n";

        $responseStandard->assertStatus(200);
        $this->assertEquals($employeeEng->uuid, $responseStandard->json('data.data.0.user.uuid'));

        // TEST 3: Standard Manager in Eng attempts to query specific user in another department
        $otherUserInSales = User::factory()->create(['name' => 'Sales Rep']);
        EmployeeProfile::create(['user_id' => $otherUserInSales->id, 'organization_id' => $org->id, 'department_id' => $deptSales->id]);
        
        $responseUnauthorized = $this->actingAs($managerStandard, 'api')
            ->withHeader('X-Organization-Id', (string) $org->id)
            ->getJson('/api/v1/leave-requests?user_id=' . $otherUserInSales->uuid);

        echo "\n[TEST 3] Standard Manager requesting user in another department without LEAVES_APPROVE_ANY:\n";
        echo "HTTP Status: " . $responseUnauthorized->status() . "\n";
        echo "============================================================\n";

        $responseUnauthorized->assertStatus(403);
    }
}
