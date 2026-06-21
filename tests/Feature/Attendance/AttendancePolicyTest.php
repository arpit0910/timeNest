<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AttendancePolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock authorization gates to simplify testing without full Spatie setup
        Gate::define('attendance.policy.create', fn (User $user) => true);
        Gate::define('attendance.policy.update', fn (User $user) => true);
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

        // Connect user to organization (assuming standard BelongsToMany pivot)
        $org->users()->attach($user->id, [
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'status' => 'active', 
            'joined_at' => now()
        ]);

        $policy = null;

        if ($createPolicy) {
            $defaultData = array_merge([
                'organization_id' => $org->id,
                'attendance_mode' => 1,
                'approval_flow' => 1,
                'shift_start_time' => '09:00:00',
                'shift_end_time' => '18:00:00',
                'required_daily_minutes' => 480,
                'minimum_session_minutes' => 15,
                'grace_late_minutes' => 15,
                'allowed_monthly_late_count' => 3,
                'allow_early_exit' => true,
                'grace_early_exit_minutes' => 0,
                'default_break_minutes' => 60,
                'max_break_minutes' => 60,
                'allow_multiple_sessions' => true,
                'allow_clock_in_on_holidays' => false,
                'auto_clock_out_enabled' => false,
                'auto_clock_out_after_minutes' => 0,
                'overtime_enabled' => false,
                'overtime_starts_after_minutes' => 0,
                'max_daily_overtime_minutes' => 0,
                'overtime_requires_approval' => false,
                'weekend_days' => [6, 7],
                'geo_fencing_enabled' => false,
                'geo_fence_radius_meters' => 0,
                'ip_restriction_enabled' => false,
                'strict_worklog_enforcement' => false,
                'created_by' => $user->id,
            ], $overrides);

            $policy = AttendancePolicy::create($defaultData);

            AttendancePolicyVersion::create(array_merge($defaultData, [
                'attendance_policy_id' => $policy->id,
                'version' => 1,
                'created_at' => now(),
            ]));
        }

        return [$user, $org, $policy];
    }

    protected function getValidPayload(): array
    {
        return [
            'attendance_mode' => 1,
            'approval_flow' => 1,
            'shift_start_time' => '09:00:00',
            'shift_end_time' => '18:00:00',
            'required_daily_minutes' => 480,
            'minimum_session_minutes' => 15,
            'grace_late_minutes' => 15,
            'allowed_monthly_late_count' => 3,
            'allow_early_exit' => true,
            'grace_early_exit_minutes' => 0,
            'default_break_minutes' => 60,
            'max_break_minutes' => 60,
            'allow_multiple_sessions' => true,
            'allow_clock_in_on_holidays' => false,
            'auto_clock_out_enabled' => false,
            'overtime_enabled' => false,
            'weekend_days' => [6, 7],
            'geo_fencing_enabled' => false,
            'ip_restriction_enabled' => false,
            'strict_worklog_enforcement' => false,
        ];
    }

    protected function actingAsTenant(User $user, Organization $org)
    {
        $this->actingAs($user, 'api');
        $this->app->instance('tenant.organization', $org);
        
        // Disable the real middleware since we are mocking the context
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
    }

    /**
     * Proves that an authorized owner can create an attendance policy 
     * and that the creation automatically triggers the first version snapshot.
     */
    public function test_owner_can_create_attendance_policy(): void
    {
        [$user, $org] = $this->createOrgWithPolicy([], false);
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/attendance/policy', $this->getValidPayload());

        $response->assertStatus(201)
            ->assertJsonPath('data.required_daily_minutes', 480);

        $this->assertDatabaseHas('attendance_policies', [
            'organization_id' => $org->id,
        ]);

        $this->assertDatabaseHas('attendance_policy_versions', [
            'organization_id' => $org->id,
            'version' => 1,
        ]);
    }

    /**
     * Proves that the system enforces a strict 1:1 relationship between 
     * Organization and AttendancePolicy by rejecting duplicates.
     */
    public function test_cannot_create_duplicate_policy_for_same_organization(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/attendance/policy', $this->getValidPayload());

        $response->assertStatus(409)
            ->assertJsonPath('error_code', 'ATTENDANCE_POLICY_ALREADY_EXISTS');
    }

    /**
     * Proves that updating a policy correctly bumps the version number
     * and applies the new state to the main policy record.
     */
    public function test_owner_can_update_policy_and_version_is_created(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy(['required_daily_minutes' => 480]);
        $this->actingAsTenant($user, $org);

        $response = $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", [
            'required_daily_minutes' => 420,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('attendance_policies', [
            'id' => $policy->id,
            'required_daily_minutes' => 420,
        ]);

        $this->assertDatabaseHas('attendance_policy_versions', [
            'attendance_policy_id' => $policy->id,
            'version' => 2,
        ]);
    }

    /**
     * Proves that updating a policy takes a snapshot of the OLD state,
     * ensuring that historical records pointing to V1 retain the correct old rules.
     */
    public function test_policy_update_preserves_old_version_snapshot(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy(['required_daily_minutes' => 480]);
        $this->actingAsTenant($user, $org);

        $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", [
            'required_daily_minutes' => 420,
        ]);

        // Version 1 should still exist and have the OLD value 480
        $this->assertDatabaseHas('attendance_policy_versions', [
            'attendance_policy_id' => $policy->id,
            'version' => 1,
            'required_daily_minutes' => 480,
        ]);
    }

    /**
     * Proves that altering a policy does not retroactively change existing historical records.
     */
    public function test_policy_change_does_not_affect_historical_records(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $version1 = AttendancePolicyVersion::where('attendance_policy_id', $policy->id)->first();

        \Illuminate\Support\Facades\DB::table('attendance_days')->insert([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'organization_id' => $org->id,
            'user_id' => $user->id,
            'attendance_policy_version_id' => $version1->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => 2,
            'compliance_status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAsTenant($user, $org);
        $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", [
            'required_daily_minutes' => 400,
        ]);

        $v1Check = AttendancePolicyVersion::find($version1->id);
        $this->assertNotNull($v1Check);
        $this->assertEquals(480, $v1Check->required_daily_minutes);
    }

    /**
     * Proves that the policy API endpoints are protected from unauthenticated access.
     */
    public function test_unauthenticated_user_cannot_access_policy(): void
    {
        $response = $this->getJson('/api/v1/attendance/policy');
        $response->assertStatus(401);
    }

    /**
     * Proves that authorization gates are actively protecting the creation endpoint.
     */
    public function test_member_without_permission_cannot_create_policy(): void
    {
        [$user, $org] = $this->createOrgWithPolicy([], false);
        $this->actingAsTenant($user, $org);

        // Explicitly deny the gate for this test
        Gate::define('attendance.policy.create', fn () => false);

        $response = $this->postJson('/api/v1/attendance/policy', $this->getValidPayload());
        $response->assertStatus(403);
    }

    /**
     * Proves that multi-tenant isolation is enforced so that one organization 
     * cannot query or modify another organization's policy by UUID.
     */
    public function test_organization_isolation(): void
    {
        [$userA, $orgA, $policyA] = $this->createOrgWithPolicy();
        [$userB, $orgB, $policyB] = $this->createOrgWithPolicy();

        $this->actingAsTenant($userA, $orgA);

        $response = $this->getJson("/api/v1/attendance/policy/{$policyB->uuid}");
        
        $response->assertStatus(404);
    }

    /**
     * Proves that the versions endpoint returns all snapshots in descending order,
     * ensuring the latest policy state is presented first.
     */
    public function test_policy_versions_are_returned_in_correct_order(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", ['required_daily_minutes' => 420]);
        $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", ['required_daily_minutes' => 400]);

        $response = $this->getJson("/api/v1/attendance/policy/{$policy->uuid}/versions");

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertCount(3, $data);
        $this->assertEquals(3, $data[0]['version']); // Highest version first
        $this->assertEquals(2, $data[1]['version']);
        $this->assertEquals(1, $data[2]['version']);
    }

    /**
     * Proves that the validation logic correctly rejects penalty slabs 
     * where the min/max minute ranges intersect with one another.
     */
    public function test_penalty_slab_overlap_is_rejected(): void
    {
        [$user, $org] = $this->createOrgWithPolicy([], false);
        $this->actingAsTenant($user, $org);

        $payload = array_merge($this->getValidPayload(), [
            'work_duration_penalty_slabs' => [
                ['min_work_minutes' => 0, 'max_work_minutes' => 240, 'deduction_percentage' => 100],
                ['min_work_minutes' => 200, 'max_work_minutes' => 400, 'deduction_percentage' => 50], // Overlaps 200-240
            ]
        ]);

        $response = $this->postJson('/api/v1/attendance/policy', $payload);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'INVALID_PENALTY_SLAB');
    }

    /**
     * Proves that penalty slabs undergo a full replacement rather than a partial patch,
     * maintaining consistency in complex multi-slab configurations.
     */
    public function test_penalty_slabs_are_replaced_on_update(): void
    {
        [$user, $org, $policy] = $this->createOrgWithPolicy();
        $this->actingAsTenant($user, $org);

        // Initial setup with 2 slabs
        $response = $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", [
            'late_penalty_slabs' => [
                ['late_count_threshold' => 3, 'deduction_percentage' => 10],
                ['late_count_threshold' => 5, 'deduction_percentage' => 20],
            ]
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseCount('attendance_late_penalty_slabs', 2);

        // Update with 1 slab
        $this->putJson("/api/v1/attendance/policy/{$policy->uuid}", [
            'late_penalty_slabs' => [
                ['late_count_threshold' => 4, 'deduction_percentage' => 15],
            ]
        ]);

        // The old 2 should be deleted, only 1 should remain
        $this->assertDatabaseCount('attendance_late_penalty_slabs', 1);
        $this->assertDatabaseHas('attendance_late_penalty_slabs', [
            'attendance_policy_id' => $policy->id,
            'late_count_threshold' => 4,
            'deduction_percentage' => 15.00
        ]);
    }
}
