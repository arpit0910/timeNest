<?php

declare(strict_types=1);

namespace Tests\Feature\Leave;

use App\Enums\MembershipStatus;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Membership\EmployeeProfile;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveApprovalHierarchyTest extends TestCase
{
    use RefreshDatabase;

    private Organization $org;
    private LeaveType $leaveType;

    protected function actingAsTenant(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');
        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user, $org, \App\Enums\Guard::ORGANIZATION, 'Manager'
        );
        $this->withToken($token);
        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
        // /api/v1/leave-requests doesn't run ResolveTenantContext (missing from
        // its route middleware -- see report), which is the only place
        // setPermissionsTeamId() gets called anywhere in this app. Simulating
        // what that middleware would do, to test the actual authorization logic
        // rather than a routing gap that's a separate, larger, unrelated fix.
        setPermissionsTeamId($org->id);
        return $this;
    }

    protected function createUser(string $name): User
    {
        $user = User::factory()->create(['name' => $name]);

        $membership = OrganizationMembership::create([
            'user_id' => $user->id,
            'organization_id' => $this->org->id,
            'status' => MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        EmployeeProfile::create([
            'user_id' => $user->id,
            'organization_id' => $this->org->id,
            'organization_membership_id' => $membership->id,
            'employee_code' => 'EMP-' . $user->id,
        ]);

        return $user;
    }

    protected function grantPermission(User $user, SystemPermission $permission): void
    {
        setPermissionsTeamId($this->org->id);
        $p = Permission::where('name', $permission->value)->where('guard_name', 'api')->first();
        if ($p) {
            $user->givePermissionTo($p);
        }
        setPermissionsTeamId(null);
    }

    protected function setReportsTo(User $user, User $manager): void
    {
        EmployeeProfile::where('user_id', $user->id)->update(['reports_to' => $manager->id]);
    }

    protected function submitLeavePayload(): array
    {
        return [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'reason' => 'Approval hierarchy test',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->org = Organization::create([
            'legal_name' => 'Hierarchy Test Org',
            'slug' => 'hierarchy-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);

        $policy = LeavePolicy::create([
            'organization_id' => $this->org->id,
            'approval_flow' => \App\Enums\Leave\ApprovalFlow::SINGLE_APPROVAL->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'document_required_after_days' => 30,
            'negative_balance_allowed' => true,
        ]);
        LeavePolicyVersion::create([
            'leave_policy_id' => $policy->id,
            'version' => 1,
            'organization_id' => $this->org->id,
            'approval_flow' => \App\Enums\Leave\ApprovalFlow::SINGLE_APPROVAL->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'document_required_after_days' => 30,
            'negative_balance_allowed' => true,
            'created_at' => now(),
        ]);
        $this->leaveType = LeaveType::create([
            'organization_id' => $this->org->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Casual Leave',
            'code' => '1',
            'annual_allocation_days' => 20,
        ]);
    }

    public function test_manager_within_hierarchy_can_approve(): void
    {
        $employee = $this->createUser('Employee');
        $manager = $this->createUser('Manager');
        $this->setReportsTo($employee, $manager);
        $this->grantPermission($employee, SystemPermission::LEAVES_CREATE);
        $this->grantPermission($manager, SystemPermission::LEAVES_APPROVE);

        $submit = $this->actingAsTenant($employee, $this->org)->postJson('/api/v1/leave-requests', $this->submitLeavePayload());
        $submit->assertStatus(201);
        $uuid = $submit->json('data.uuid');

        $approve = $this->actingAsTenant($manager, $this->org)->postJson("/api/v1/leave-requests/{$uuid}/approve", []);

        echo "\n=== APPROVE WITHIN HIERARCHY ===\nStatus: {$approve->status()}\nBody: {$approve->getContent()}\n";

        $approve->assertStatus(200);
        $approve->assertJsonPath('data.leave_status.value', \App\Enums\Leave\LeaveStatus::APPROVED->value);
    }

    public function test_approver_outside_hierarchy_is_blocked(): void
    {
        $employee = $this->createUser('Employee');
        $manager = $this->createUser('Actual Manager');
        $outsider = $this->createUser('Unrelated Manager');
        $this->setReportsTo($employee, $manager);
        $this->grantPermission($employee, SystemPermission::LEAVES_CREATE);
        // Outsider holds LEAVES_APPROVE but is NOT this employee's manager.
        $this->grantPermission($outsider, SystemPermission::LEAVES_APPROVE);

        $submit = $this->actingAsTenant($employee, $this->org)->postJson('/api/v1/leave-requests', $this->submitLeavePayload());
        $submit->assertStatus(201);
        $uuid = $submit->json('data.uuid');

        $approve = $this->actingAsTenant($outsider, $this->org)->postJson("/api/v1/leave-requests/{$uuid}/approve", []);

        echo "\n=== APPROVE OUTSIDE HIERARCHY (should be blocked) ===\nStatus: {$approve->status()}\nBody: {$approve->getContent()}\n";

        $approve->assertStatus(403);
        $approve->assertJsonPath('error_code', 'UNAUTHORIZED_LEAVE_ACTION');
    }

    public function test_leaves_approve_any_bypasses_hierarchy(): void
    {
        $employee = $this->createUser('Employee');
        $manager = $this->createUser('Actual Manager');
        $hr = $this->createUser('HR With Approve Any');
        $this->setReportsTo($employee, $manager);
        $this->grantPermission($employee, SystemPermission::LEAVES_CREATE);
        $this->grantPermission($hr, SystemPermission::LEAVES_APPROVE_ANY);

        $submit = $this->actingAsTenant($employee, $this->org)->postJson('/api/v1/leave-requests', $this->submitLeavePayload());
        $submit->assertStatus(201);
        $uuid = $submit->json('data.uuid');

        $approve = $this->actingAsTenant($hr, $this->org)->postJson("/api/v1/leave-requests/{$uuid}/approve", []);

        echo "\n=== APPROVE_ANY BYPASSES HIERARCHY ===\nStatus: {$approve->status()}\n";

        $approve->assertStatus(200);
    }

    public function test_self_approval_still_blocked(): void
    {
        $employee = $this->createUser('Employee');
        $this->grantPermission($employee, SystemPermission::LEAVES_CREATE);
        // Employee also happens to hold LEAVES_APPROVE_ANY -- permission alone must not be enough.
        $this->grantPermission($employee, SystemPermission::LEAVES_APPROVE_ANY);

        $submit = $this->actingAsTenant($employee, $this->org)->postJson('/api/v1/leave-requests', $this->submitLeavePayload());
        $submit->assertStatus(201);
        $uuid = $submit->json('data.uuid');

        $approve = $this->actingAsTenant($employee, $this->org)->postJson("/api/v1/leave-requests/{$uuid}/approve", []);

        echo "\n=== SELF-APPROVAL (should be blocked even with LEAVES_APPROVE_ANY) ===\nStatus: {$approve->status()}\nBody: {$approve->getContent()}\n";

        $approve->assertStatus(403);
        $approve->assertJsonPath('error_code', 'UNAUTHORIZED_LEAVE_ACTION');
    }

    public function test_reject_within_hierarchy_works_outside_blocked(): void
    {
        $employee = $this->createUser('Employee');
        $manager = $this->createUser('Manager');
        $outsider = $this->createUser('Outsider');
        $this->setReportsTo($employee, $manager);
        $this->grantPermission($employee, SystemPermission::LEAVES_CREATE);
        $this->grantPermission($manager, SystemPermission::LEAVES_APPROVE);
        $this->grantPermission($outsider, SystemPermission::LEAVES_APPROVE);

        $submit = $this->actingAsTenant($employee, $this->org)->postJson('/api/v1/leave-requests', $this->submitLeavePayload());
        $uuid = $submit->json('data.uuid');

        $blockedReject = $this->actingAsTenant($outsider, $this->org)->postJson("/api/v1/leave-requests/{$uuid}/reject", [
            'rejection_reason' => 'Not my subordinate',
        ]);
        $blockedReject->assertStatus(403);

        $allowedReject = $this->actingAsTenant($manager, $this->org)->postJson("/api/v1/leave-requests/{$uuid}/reject", [
            'rejection_reason' => 'Denied by actual manager',
        ]);

        echo "\n=== REJECT WITHIN HIERARCHY ===\nStatus: {$allowedReject->status()}\nBody: {$allowedReject->getContent()}\n";

        $allowedReject->assertStatus(200);
    }
}
