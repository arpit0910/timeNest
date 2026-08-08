<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use App\Models\Worklog\WorklogPolicy;
use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WorklogPolicyTest extends TestCase
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
            'password' => bcrypt('password'),
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
        $viewPermission = Permission::where('name', SystemPermission::WORKLOG_POLICY_VIEW->value)->where('guard_name', 'api')->first();
        $managePermission = Permission::where('name', SystemPermission::WORKLOG_POLICY_MANAGE->value)->where('guard_name', 'api')->first();
        if ($viewPermission) {
            $user->givePermissionTo($viewPermission);
        }
        if ($managePermission) {
            $user->givePermissionTo($managePermission);
        }
        setPermissionsTeamId(null);

        return [$user, $org];
    }

    protected function getValidPayload(): array
    {
        return [
            'worklog_mode' => 1,
            'approval_flow' => 1,
            'require_worklog_on_clockout' => false,
            'allow_deferred_submission' => true,
            'submission_window_days' => 7,
            'edit_grace_days' => 2,
            'lock_after_days' => 14,
            'require_description' => true,
            'min_description_length' => 10,
            'require_justification_on_overflow' => false,
            'require_project_mapping' => false,
            'require_task_mapping' => false,
            'allow_multiple_worklogs_per_session' => true,
            'auto_escalate_overdue_logs' => false,
            'billable_tracking_enabled' => false,
        ];
    }

    public function test_owner_can_set_worklog_policy(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        $response = $this->actingAsTenant($user, $org)
            ->patchJson('/api/v1/organization/attendance/worklog-policy', $this->getValidPayload());

        $response->assertStatus(200)
            ->assertJsonPath('data.submission_window_days', 7);

        $this->assertDatabaseHas('worklog_policies', [
            'organization_id' => $org->id,
            'submission_window_days' => 7,
        ]);

        $this->assertDatabaseHas('worklog_policy_versions', [
            'organization_id' => $org->id,
            'version' => 2, // v1 is the default snapshot created on first GET/PATCH, v2 is this update
        ]);
    }

    public function test_first_access_creates_default_policy_with_version_one(): void
    {
        [$user, $org] = $this->createOrgWithUser();

        $response = $this->actingAsTenant($user, $org)
            ->getJson('/api/v1/organization/attendance/worklog-policy');

        $response->assertStatus(200);

        $policy = WorklogPolicy::where('organization_id', $org->id)->first();
        $this->assertNotNull($policy);
        $this->assertDatabaseHas('worklog_policy_versions', [
            'worklog_policy_id' => $policy->id,
            'version' => 1,
        ]);
        $this->assertSame(1, WorklogPolicyVersion::where('worklog_policy_id', $policy->id)->count());
    }

    public function test_latest_version_matches_live_policy_state_after_update(): void
    {
        [$user, $org] = $this->createOrgWithUser();
        $this->actingAsTenant($user, $org);

        $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 7]);
        $response = $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 14]);

        $response->assertStatus(200);

        $policy = WorklogPolicy::where('organization_id', $org->id)->first();

        $this->assertDatabaseHas('worklog_policies', [
            'id' => $policy->id,
            'submission_window_days' => 14,
        ]);

        $this->assertDatabaseHas('worklog_policy_versions', [
            'worklog_policy_id' => $policy->id,
            'version' => 3,
            'submission_window_days' => 14,
        ]);
    }

    public function test_old_version_snapshot_is_preserved_after_update(): void
    {
        [$user, $org] = $this->createOrgWithUser();
        $this->actingAsTenant($user, $org);

        $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 7]);
        $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 14]);

        $policy = WorklogPolicy::where('organization_id', $org->id)->first();

        $this->assertDatabaseHas('worklog_policy_versions', [
            'worklog_policy_id' => $policy->id,
            'version' => 2,
            'submission_window_days' => 7,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_worklog_policy(): void
    {
        $response = $this->getJson('/api/v1/organization/attendance/worklog-policy');
        $response->assertStatus(401);
    }

    public function test_organization_isolation_on_worklog_policy(): void
    {
        [$userA, $orgA] = $this->createOrgWithUser();
        [$userB, $orgB] = $this->createOrgWithUser();

        $this->actingAsTenant($userA, $orgA)
            ->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 5])
            ->assertStatus(200);

        $this->actingAsTenant($userB, $orgB)
            ->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 9])
            ->assertStatus(200);

        // The canonical endpoint takes no org/uuid input from the client at all —
        // the org is resolved solely from the tenant JWT context, so there is no
        // request shape that could ever target another tenant's policy. Confirm
        // each tenant only ever sees its own row, and the two rows stayed distinct.
        $policyA = WorklogPolicy::where('organization_id', $orgA->id)->first();
        $policyB = WorklogPolicy::where('organization_id', $orgB->id)->first();

        $this->assertNotEquals($policyA->id, $policyB->id);
        $this->assertSame(5, $policyA->submission_window_days);
        $this->assertSame(9, $policyB->submission_window_days);

        $responseA = $this->actingAsTenant($userA, $orgA)->getJson('/api/v1/organization/attendance/worklog-policy');
        $responseA->assertStatus(200)->assertJsonPath('data.submission_window_days', 5);
    }

    public function test_versions_returned_in_descending_order(): void
    {
        [$user, $org] = $this->createOrgWithUser();
        $this->actingAsTenant($user, $org);

        $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 7]);
        $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 8]);
        $this->patchJson('/api/v1/organization/attendance/worklog-policy', ['submission_window_days' => 9]);

        $response = $this->getJson('/api/v1/organization/attendance/worklog-policy/versions');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(4, $data); // v1 default + 3 updates
        $this->assertEquals(4, $data[0]['id']);
        $this->assertEquals(3, $data[1]['id']);
        $this->assertEquals(2, $data[2]['id']);
        $this->assertEquals(1, $data[3]['id']);
    }
}
