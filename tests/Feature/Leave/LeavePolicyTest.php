<?php

declare(strict_types=1);

namespace Tests\Feature\Leave;

use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Organization\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

class LeavePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('leave.policy.create', fn (User $user) => true);
        Gate::define('leave.policy.update', fn (User $user) => true);
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
            'type' => \App\Enums\Organization\OrganizationType::Organization->value,
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
                'approval_flow' => 1,
                'allow_half_day_leaves' => true,
                'allow_leave_on_weekends' => false,
                'allow_leave_on_holidays' => false,
                'advance_notice_required_days' => 1,
                'max_advance_application_days' => 90,
                'document_required_after_days' => 3,
                'allow_leave_cancellation' => true,
                'cancellation_before_hours' => 24,
                'carry_forward_enabled' => false,
                'max_carry_forward_days' => 0,
                'carry_forward_expiry_months' => 3,
                'accrual_enabled' => false,
                'accrual_frequency' => null,
                'negative_balance_allowed' => false,
                'auto_approve_after_hours' => null,
                'created_by' => $user->id,
            ], $overrides);

            $policy = LeavePolicy::create($defaultData);

            LeavePolicyVersion::create(array_merge($defaultData, [
                'leave_policy_id' => $policy->id,
                'version' => 1,
                'created_at' => now(),
            ]));
        }

        return [$user, $org, $policy];
    }

    protected function getValidPayload(): array
    {
        return [
            'approval_flow' => 1,
            'allow_half_day_leaves' => true,
            'allow_leave_on_weekends' => false,
            'allow_leave_on_holidays' => false,
            'advance_notice_required_days' => 1,
            'max_advance_application_days' => 90,
            'document_required_after_days' => 3,
            'allow_leave_cancellation' => true,
            'cancellation_before_hours' => 24,
            'carry_forward_enabled' => false,
            'accrual_enabled' => false,
            'negative_balance_allowed' => false,
        ];
    }

    public function test_owner_can_create_leave_policy(): void
    {
        [$user, $org] = $this->createOrgWithPolicy([], false);
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/leave/policy', $this->getValidPayload());

        $response->assertStatus(201)
            ->assertJsonPath('data.advance_notice_required_days', 1);

        $this->assertDatabaseHas('leave_policies', [
            'organization_id' => $org->id,
        ]);

        $this->assertDatabaseHas('leave_policy_versions', [
            'organization_id' => $org->id,
            'version' => 1,
        ]);
    }

    public function test_cannot_create_duplicate_leave_policy(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/leave/policy', $this->getValidPayload());

        $response->assertStatus(409)
            ->assertJsonPath('error_code', 'LEAVE_POLICY_ALREADY_EXISTS');
    }

    public function test_latest_version_matches_live_policy_state_after_update(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy(['advance_notice_required_days' => 1]);
        $this->actingAsTenant($user, $org);

        $response = $this->putJson("/api/v1/leave/policy/{$policy->uuid}", [
            'advance_notice_required_days' => 3,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_policies', [
            'id' => $policy->id,
            'advance_notice_required_days' => 3,
        ]);

        $this->assertDatabaseHas('leave_policy_versions', [
            'leave_policy_id' => $policy->id,
            'version' => 2,
            'advance_notice_required_days' => 3,
        ]);
    }

    public function test_old_version_snapshot_is_preserved_after_update(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy(['carry_forward_enabled' => false]);
        $this->actingAsTenant($user, $org);

        $this->putJson("/api/v1/leave/policy/{$policy->uuid}", [
            'carry_forward_enabled' => true,
            'max_carry_forward_days' => 10,
            'carry_forward_expiry_months' => 3,
        ]);

        $this->assertDatabaseHas('leave_policy_versions', [
            'leave_policy_id' => $policy->id,
            'version' => 1,
            'carry_forward_enabled' => false,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_leave_policy(): void
    {
        $response = $this->getJson('/api/v1/leave/policy');
        $response->assertStatus(401);
    }

    public function test_organization_isolation_on_leave_policy(): void
    {
        [$userA, $orgA, $policyA] = $this->createOrgWithPolicy();
        [$userB, $orgB, $policyB] = $this->createOrgWithPolicy();

        $this->actingAsTenant($userA, $orgA);

        $response = $this->getJson("/api/v1/leave/policy/{$policyB->uuid}");
        $response->assertStatus(404);
    }

    public function test_versions_returned_in_descending_order(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        $this->putJson("/api/v1/leave/policy/{$policy->uuid}", ['advance_notice_required_days' => 2]);
        $this->putJson("/api/v1/leave/policy/{$policy->uuid}", ['advance_notice_required_days' => 3]);

        $response = $this->getJson("/api/v1/leave/policy/{$policy->uuid}/versions");

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertCount(3, $data);
        $this->assertEquals(3, $data[0]['id']);
        $this->assertEquals(2, $data[1]['id']);
        $this->assertEquals(1, $data[2]['id']);
    }
}
