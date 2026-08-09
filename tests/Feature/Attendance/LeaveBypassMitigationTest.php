<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\Leave\ApprovalFlow;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Proves the state of the LeaveController -> LeaveManagementService/LeaveStatusTransitionService
 * path (routed at /api/v1/organization/attendance/leaves), as distinct from the
 * LeaveRequestController -> LeaveRequestService path (/api/v1/leave-requests).
 */
class LeaveBypassMitigationTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsTenant(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');

        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user,
            $org,
            \App\Enums\Guard::ORGANIZATION,
            'Manager'
        );
        $this->withToken($token);

        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);

        return $this;
    }

    protected function createOrgWithUser(): array
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test' . uniqid() . '@example.com',
        ]);

        $org = Organization::create([
            'legal_name' => 'Test Organization',
            'slug' => 'test-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);

        $org->users()->attach($user->id, [
            'uuid' => (string) Str::uuid(),
            'status' => 'active',
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($org->id);
        foreach (['LEAVES_VIEW', 'LEAVES_CREATE', 'LEAVES_APPROVE'] as $perm) {
            $p = Permission::where('name', \App\Enums\SystemPermission::{$perm}->value)->where('guard_name', 'api')->first();
            if ($p) {
                $user->givePermissionTo($p);
            }
        }
        setPermissionsTeamId(null);

        $policy = LeavePolicy::create([
            'organization_id' => $org->id,
            'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'document_required_after_days' => 30,
            'negative_balance_allowed' => false,
            'created_by' => $user->id,
        ]);
        LeavePolicyVersion::create([
            'leave_policy_id' => $policy->id,
            'version' => 1,
            'organization_id' => $org->id,
            'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'document_required_after_days' => 30,
            'negative_balance_allowed' => false,
            'created_by' => $user->id,
            'created_at' => now(),
        ]);
        $leaveType = LeaveType::create([
            'organization_id' => $org->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Casual Leave',
            'code' => '1',
            'annual_allocation_days' => 20,
            'created_by' => $user->id,
        ]);

        return [$user, $org, $leaveType];
    }

    protected function validLeavePayload(string $leaveTypeUuid, string $startDate, string $endDate): array
    {
        return [
            'leave_type_id' => $leaveTypeUuid,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'reason' => 'Test leave',
        ];
    }

    public function test_self_approval_is_blocked_after_fix(): void
    {
        [$user, $org, $leaveType] = $this->createOrgWithUser();
        $this->actingAsTenant($user, $org);

        $submit = $this->postJson('/api/v1/organization/attendance/leaves', $this->validLeavePayload(
            $leaveType->uuid,
            now()->addDays(5)->toDateString(),
            now()->addDays(6)->toDateString()
        ));
        $submit->assertStatus(201);
        $uuid = $submit->json('data.uuid');

        $selfApprove = $this->patchJson("/api/v1/organization/attendance/leaves/{$uuid}/status", [
            'status' => \App\Enums\Leave\LeaveStatus::APPROVED->value,
        ]);

        echo "\n================ SELF-APPROVAL TEST ================\n";
        echo "HTTP Status: " . $selfApprove->status() . "\n";
        echo "Body: " . $selfApprove->getContent() . "\n";
        echo "======================================================\n";

        // Blocked by EmployeeLeavePolicy::approve() -> withinApprovalHierarchy()'s
        // explicit self-check, via $this->authorize('approve', $leave) in
        // LeaveController::updateStatus() — before LeaveStatusTransitionService
        // is ever reached, so this is Laravel's generic AuthorizationException
        // response (no error_code), not UnauthorizedLeaveActionException's shape.
        $selfApprove->assertStatus(403);
    }

    public function test_overlap_detection_already_works_on_leaves_endpoint(): void
    {
        [$user, $org, $leaveType] = $this->createOrgWithUser();
        $this->actingAsTenant($user, $org);

        $first = $this->postJson('/api/v1/organization/attendance/leaves', $this->validLeavePayload(
            $leaveType->uuid,
            now()->addDays(10)->toDateString(),
            now()->addDays(12)->toDateString()
        ));
        $first->assertStatus(201);

        $overlapping = $this->postJson('/api/v1/organization/attendance/leaves', $this->validLeavePayload(
            $leaveType->uuid,
            now()->addDays(11)->toDateString(),
            now()->addDays(13)->toDateString()
        ));

        echo "\n================ OVERLAP TEST ================\n";
        echo "HTTP Status: " . $overlapping->status() . "\n";
        echo "Body: " . $overlapping->getContent() . "\n";
        echo "================================================\n";

        $overlapping->assertStatus(422);
        $overlapping->assertJsonPath('error_code', 'LEAVE_OVERLAP');
    }
}
