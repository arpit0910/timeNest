<?php

declare(strict_types=1);

namespace Tests\Feature\Leave;

use App\Actions\IssueJwtAction;
use App\Enums\Guard;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LeaveTypeTest extends TestCase
{
    use RefreshDatabase;

    /** See LeavePolicyTest::grantLeavePolicyManage() for why this grants both view and manage. */
    protected function grantLeavePolicyManage(User $user, Organization $org): void
    {
        setPermissionsTeamId($org->id);
        $permissions = Permission::whereIn('name', [
            SystemPermission::LEAVE_POLICY_VIEW->value,
            SystemPermission::LEAVE_POLICY_MANAGE->value,
        ])->where('guard_name', 'api')->get();
        $user->givePermissionTo($permissions);
        setPermissionsTeamId(null);
    }

    /**
     * Issues a real JWT and attaches it as a Bearer token — the app's
     * JwtAuthenticate middleware parses the request's own Authorization
     * header regardless of Laravel's guard-level auth state, so plain
     * actingAs() alone (without a real token) 401s under the real
     * api.organization middleware stack. See LegacyMiddlewareFixTest.php.
     */
    protected function actingAsTenant(User $user, Organization $org): void
    {
        $this->actingAs($user, 'api');
        $token = app(IssueJwtAction::class)->issueAccessToken($user, $org, Guard::ORGANIZATION);
        $this->withToken($token);
    }

    protected function createOrgWithPolicyAndType(): array
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
            'account_type' => \App\Enums\AccountType::ORGANIZATION->value,
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

        $this->grantLeavePolicyManage($user, $org);

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
            'code' => '1', // App\Enums\Leave\LeaveType::CASUAL
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
            'code' => '2', // App\Enums\Leave\LeaveType::SICK
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
            ->assertJsonPath('data.code', '2');

        $this->assertDatabaseHas('leave_types', [
            'leave_policy_id' => $policy->id,
            'code' => '2',
        ]);
    }

    /**
     * `code` must be one of App\Enums\Leave\LeaveType's values — anything
     * else used to pass this free-text `alpha_dash` validation and then
     * throw an uncaught ValueError the first time anyone submitted leave
     * against it (LeaveTypeEnum::from((int) $leaveType->code)).
     */
    public function test_out_of_range_code_is_rejected(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $payload = $this->getValidPayload();
        $payload['code'] = 'SICK';

        $response = $this->postJson("/api/v1/leave/policy/{$policy->uuid}/types", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('code');
    }

    public function test_duplicate_code_is_rejected(): void
    {
        [$user, $org, $policy, $type] = $this->createOrgWithPolicyAndType();
        $this->actingAsTenant($user, $org);

        $payload = $this->getValidPayload();
        $payload['code'] = '1'; // already used by CASUAL, created in setUp

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
