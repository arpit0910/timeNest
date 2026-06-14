<?php

declare(strict_types=1);

namespace Tests\Feature\Leave;

use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

class LeaveTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('leave.type.create', fn (User $user) => true);
        Gate::define('leave.type.update', fn (User $user) => true);
    }

    protected function actingAsTenant(User $user, Organization $org)
    {
        $this->actingAs($user, 'api');
        $this->app->instance('tenant.organization', $org);
        
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
    }

    protected function createOrgWithPolicyAndType(): array
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

        $policy = LeavePolicy::create([
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
            'accrual_enabled' => false,
            'negative_balance_allowed' => false,
            'created_by' => $user->id,
        ]);

        $type = LeaveType::create([
            'organization_id' => $org->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Casual Leave',
            'code' => 'CASUAL',
            'color_hex' => '#FF0000',
            'is_paid' => true,
            'is_system_type' => false,
            'requires_document' => false,
            'allow_half_day' => true,
            'annual_allocation_days' => 12,
            'min_per_request_days' => 0.5,
            'is_active' => true,
            'created_by' => $user->id,
        ]);

        return [$user, $org, $policy, $type];
    }

    protected function getValidPayload(): array
    {
        return [
            'name' => 'Sick Leave',
            'code' => 'SICK',
            'color_hex' => '#00FF00',
            'is_paid' => true,
            'requires_document' => true,
            'allow_half_day' => true,
            'annual_allocation_days' => 6,
            'min_per_request_days' => 0.5,
            'is_active' => true,
        ];
    }

    public function test_can_create_leave_type_for_policy(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $response = $this->postJson("/api/v1/leave/policy/{$policy->uuid}/types", $this->getValidPayload());

        $response->assertStatus(201)
            ->assertJsonPath('data.code', 'SICK');

        $this->assertDatabaseHas('leave_types', [
            'leave_policy_id' => $policy->id,
            'code' => 'SICK',
        ]);
    }

    public function test_code_is_forced_to_uppercase(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $payload = $this->getValidPayload();
        $payload['code'] = 'sick';

        $response = $this->postJson("/api/v1/leave/policy/{$policy->uuid}/types", $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('leave_types', [
            'leave_policy_id' => $policy->id,
            'code' => 'SICK', // Stored in uppercase
        ]);
    }

    public function test_duplicate_code_is_rejected(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $payload = $this->getValidPayload();
        $payload['code'] = 'CASUAL'; // CASUAL already created in setUp

        $response = $this->postJson("/api/v1/leave/policy/{$policy->uuid}/types", $payload);

        $response->assertStatus(409)
            ->assertJsonPath('error_code', 'LEAVE_TYPE_CODE_ALREADY_EXISTS');
    }

    public function test_system_type_cannot_be_deleted(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $type->update(['is_system_type' => true]);

        $response = $this->deleteJson("/api/v1/leave/types/{$type->uuid}");

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'CANNOT_DELETE_SYSTEM_LEAVE_TYPE');
    }

    public function test_non_system_type_can_be_soft_deleted(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $response = $this->deleteJson("/api/v1/leave/types/{$type->uuid}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('leave_types', ['id' => $type->id]);
    }

    public function test_deactivate_type_sets_is_active_false(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $response = $this->patchJson("/api/v1/leave/types/{$type->uuid}/deactivate");

        $response->assertStatus(200)
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseHas('leave_types', [
            'id' => $type->id,
            'is_active' => false,
        ]);
    }

    public function test_organization_isolation_on_leave_type(): void
    {
        [$userA, $orgA, $policyA, $typeA] = $this->createOrgWithPolicyAndType();
        [$userB, $orgB, $policyB, $typeB] = $this->createOrgWithPolicyAndType();

        $this->actingAsTenant($userA, $orgA);

        $response = $this->putJson("/api/v1/leave/types/{$typeB->uuid}", ['name' => 'Updated']);
        $response->assertStatus(404);

        $responseDelete = $this->deleteJson("/api/v1/leave/types/{$typeB->uuid}");
        $responseDelete->assertStatus(404);
    }
}
