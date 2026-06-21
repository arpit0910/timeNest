<?php

declare(strict_types=1);

namespace Tests\Feature\Worklog;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Worklog\WorklogPolicy;
use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

class WorklogPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('worklog.policy.create', fn (User $user) => true);
        Gate::define('worklog.policy.update', fn (User $user) => true);
    }

    protected function actingAsTenant(User $user, Organization $org)
    {
        $this->actingAs($user, 'api');
        $this->app->instance('tenant.organization', $org);
        
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
    }

    protected function createOrgWithPolicy(array $overrides = [], bool $createPolicy = true): array
    {
        $user = User::create([
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
            'joined_at' => now()
        ]);

        $policy = null;

        if ($createPolicy) {
            $defaultData = array_merge([
                'organization_id' => $org->id,
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
                'created_by' => $user->id,
            ], $overrides);

            $policy = WorklogPolicy::create($defaultData);

            WorklogPolicyVersion::create(array_merge($defaultData, [
                'worklog_policy_id' => $policy->id,
                'version' => 1,
                'created_at' => now(),
            ]));
        }

        return [$user, $org, $policy];
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

    public function test_owner_can_create_worklog_policy(): void
    {
        [$user, $org] = $this->createOrgWithPolicy([], false);
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/worklog/policy', $this->getValidPayload());

        $response->assertStatus(201)
            ->assertJsonPath('data.submission_window_days', 7);

        $this->assertDatabaseHas('worklog_policies', [
            'organization_id' => $org->id,
        ]);

        $this->assertDatabaseHas('worklog_policy_versions', [
            'organization_id' => $org->id,
            'version' => 1,
        ]);
    }

    public function test_cannot_create_duplicate_worklog_policy(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/worklog/policy', $this->getValidPayload());

        $response->assertStatus(409)
            ->assertJsonPath('error_code', 'WORKLOG_POLICY_ALREADY_EXISTS');
    }

    public function test_latest_version_matches_live_policy_state_after_update(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy(['submission_window_days' => 7]);
        $this->actingAsTenant($user, $org);

        $response = $this->putJson("/api/v1/worklog/policy/{$policy->uuid}", [
            'submission_window_days' => 14,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('worklog_policies', [
            'id' => $policy->id,
            'submission_window_days' => 14,
        ]);

        $this->assertDatabaseHas('worklog_policy_versions', [
            'worklog_policy_id' => $policy->id,
            'version' => 2,
            'submission_window_days' => 14,
        ]);
    }

    public function test_old_version_snapshot_is_preserved_after_update(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy(['submission_window_days' => 7]);
        $this->actingAsTenant($user, $org);

        $this->putJson("/api/v1/worklog/policy/{$policy->uuid}", [
            'submission_window_days' => 14,
        ]);

        $this->assertDatabaseHas('worklog_policy_versions', [
            'worklog_policy_id' => $policy->id,
            'version' => 1,
            'submission_window_days' => 7,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_worklog_policy(): void
    {
        $response = $this->getJson('/api/v1/worklog/policy');
        $response->assertStatus(401);
    }

    public function test_organization_isolation_on_worklog_policy(): void
    {
        [$userA, $orgA, $policyA] = $this->createOrgWithPolicy();
        [$userB, $orgB, $policyB] = $this->createOrgWithPolicy();

        $this->actingAsTenant($userA, $orgA);

        $response = $this->getJson("/api/v1/worklog/policy/{$policyB->uuid}");
        $response->assertStatus(404);
    }

    public function test_versions_returned_in_descending_order(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        $this->putJson("/api/v1/worklog/policy/{$policy->uuid}", ['submission_window_days' => 8]);
        $this->putJson("/api/v1/worklog/policy/{$policy->uuid}", ['submission_window_days' => 9]);

        $response = $this->getJson("/api/v1/worklog/policy/{$policy->uuid}/versions");

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertCount(3, $data);
        $this->assertEquals(3, $data[0]['id']);
        $this->assertEquals(2, $data[1]['id']);
        $this->assertEquals(1, $data[2]['id']);
    }
}
