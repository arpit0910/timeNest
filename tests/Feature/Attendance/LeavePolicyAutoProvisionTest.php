<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\Leave\ApprovalFlow;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LeavePolicyAutoProvisionTest extends TestCase
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
        foreach (['LEAVES_VIEW', 'LEAVES_CREATE'] as $perm) {
            $p = Permission::where('name', \App\Enums\SystemPermission::{$perm}->value)->where('guard_name', 'api')->first();
            if ($p) {
                $user->givePermissionTo($p);
            }
        }
        setPermissionsTeamId(null);

        return [$user, $org];
    }

    public function test_org_with_existing_policy_and_type_still_submits(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        $policy = LeavePolicy::create([
            'organization_id' => $org->id,
            'approval_flow' => ApprovalFlow::AUTO->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'document_required_after_days' => 30,
            'negative_balance_allowed' => false,
            'created_by' => $user->id,
        ]);
        \App\Models\Leave\LeavePolicyVersion::create([
            'leave_policy_id' => $policy->id,
            'version' => 1,
            'organization_id' => $org->id,
            'approval_flow' => ApprovalFlow::AUTO->value,
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
            'name' => 'Pre-existing Casual Leave',
            'code' => '1',
            'annual_allocation_days' => 20,
            'created_by' => $user->id,
        ]);

        $response = $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => $leaveType->uuid,
            'start_date' => now()->addDays(3)->toDateString(),
            'end_date' => now()->addDays(4)->toDateString(),
            'reason' => 'Pre-existing policy submission test',
        ]);

        echo "\n=== EXISTING POLICY ORG ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(201);
        // No NEW policy should have been created — still exactly 1 for this org.
        $this->assertSame(1, LeavePolicy::where('organization_id', $org->id)->count());
    }

    public function test_org_with_no_policy_auto_provisions_then_submits(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        $this->assertSame(0, LeavePolicy::where('organization_id', $org->id)->count());
        $this->assertSame(0, LeaveType::where('organization_id', $org->id)->count());

        // First attempt: caller can't know a leave_type_id UUID that doesn't exist
        // yet for a never-provisioned org. This attempt triggers auto-provisioning
        // (policy + default types) as a side effect, then 404s on the bogus UUID.
        $bogusAttempt = $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => (string) Str::uuid(),
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'reason' => 'Triggers auto-provisioning',
        ]);

        echo "\n=== NO-POLICY ORG: first attempt (unknown leave_type_id) ===\nStatus: {$bogusAttempt->status()}\nBody: {$bogusAttempt->getContent()}\n";

        $bogusAttempt->assertStatus(404);

        $newPolicy = LeavePolicy::where('organization_id', $org->id)->first();
        echo "Policy auto-created: " . ($newPolicy ? 'yes (id=' . $newPolicy->id . ')' : 'no') . "\n";
        $this->assertNotNull($newPolicy, 'Expected getOrCreatePolicy() to have auto-provisioned a LeavePolicy row.');

        $newTypes = LeaveType::where('organization_id', $org->id)->get();
        echo "Default LeaveTypes created: " . $newTypes->count() . " -> " . $newTypes->pluck('name')->implode(', ') . "\n";
        $this->assertSame(4, $newTypes->count());

        $version = \App\Models\Leave\LeavePolicyVersion::where('leave_policy_id', $newPolicy->id)->count();
        echo "Version snapshots created: {$version}\n";
        $this->assertSame(1, $version);

        // Second attempt: now using a real, auto-provisioned leave_type_id.
        $casual = $newTypes->firstWhere('code', '1');
        $realAttempt = $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => $casual->uuid,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'reason' => 'Now using a real auto-provisioned leave type',
        ]);

        echo "\n=== NO-POLICY ORG: second attempt (real auto-provisioned leave_type_id) ===\nStatus: {$realAttempt->status()}\nBody: {$realAttempt->getContent()}\n";

        $realAttempt->assertStatus(201);

        // Confirm no duplicate policy/types got created on the second call.
        $this->assertSame(1, LeavePolicy::where('organization_id', $org->id)->count());
        $this->assertSame(4, LeaveType::where('organization_id', $org->id)->count());
    }

    public function test_balance_check_now_enforced(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        // Auto-provision via the same trigger, then submit Casual Leave (12-day
        // allocation) for 13 days to exceed it (negative_balance_allowed=false).
        // attachment_path included to isolate the balance check from the
        // document-required-after-3-days check, which would otherwise fire first.
        $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => (string) Str::uuid(),
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'reason' => 'Trigger provisioning',
        ]);

        $casual = LeaveType::where('organization_id', $org->id)->where('code', '1')->firstOrFail();
        $this->assertSame('12.00', (string) $casual->annual_allocation_days);

        $response = $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => $casual->uuid,
            'start_date' => now()->addDays(20)->toDateString(),
            'end_date' => now()->addDays(32)->toDateString(), // 13 days, exceeds 12-day allocation
            'reason' => 'Should fail balance check (13 days requested, 12 allocated, negative not allowed)',
            'attachment_path' => 'https://example.com/doc.pdf',
        ]);

        echo "\n=== BALANCE CHECK ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(422);
        $response->assertJsonPath('error_code', 'INSUFFICIENT_LEAVE_BALANCE');
    }

    public function test_unpaid_leave_exempt_from_balance_check(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => (string) Str::uuid(),
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'reason' => 'Trigger provisioning',
        ]);

        $unpaid = LeaveType::where('organization_id', $org->id)->where('code', '4')->firstOrFail();
        $this->assertSame('Unpaid Leave', $unpaid->name);
        $this->assertSame('0.00', (string) $unpaid->annual_allocation_days);
        $this->assertFalse((bool) $unpaid->counts_towards_balance);

        $response = $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => $unpaid->uuid,
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(11)->toDateString(),
            'reason' => 'Zero allocation, but balance-exempt, so this must succeed',
        ]);

        echo "\n=== UNPAID LEAVE (balance-exempt) ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(201);
    }

    public function test_advance_notice_check_now_enforced(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => (string) Str::uuid(),
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'reason' => 'Trigger provisioning',
        ]);

        $casual = LeaveType::where('organization_id', $org->id)->where('code', '1')->firstOrFail();

        // Default policy requires 1 day of advance notice; submit for TODAY.
        $response = $this->actingAsTenant($user, $org)->postJson('/api/v1/organization/attendance/leaves', [
            'leave_type_id' => $casual->uuid,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'reason' => 'Should fail advance-notice check (0 days notice, 1 required)',
        ]);

        echo "\n=== ADVANCE NOTICE CHECK ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(422);
    }
}
