<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\Attendance\AttendanceStatus;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\OrganizationHoliday;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendanceDayComputationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AttendanceClockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Lock time to a Monday so tests don't fail if run on a weekend
        // using an arbitrary Monday: 2024-01-01 was a Monday
        Carbon::setTestNow(Carbon::create(2024, 1, 1, 9, 0, 0));
    }

    /**
     * Create an organization with an attendance policy and policy version.
     *
     * @param array $policyOverrides
     * @return array [User, Organization, AttendancePolicy, AttendancePolicyVersion]
     */
    protected function createOrgWithAttendancePolicy(array $policyOverrides = []): array
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
            'joined_at' => now(),
        ]);

        $defaultData = array_merge([
            'organization_id' => $org->id,
            'attendance_mode' => 1, // Strict
            'approval_flow' => 1,   // Auto
            'shift_start_time' => '09:00:00',
            'shift_end_time' => '18:00:00',
            'required_daily_minutes' => 480,
            'minimum_session_minutes' => 1,
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
        ], $policyOverrides);

        $policy = AttendancePolicy::create($defaultData);

        $version = AttendancePolicyVersion::create(array_merge($defaultData, [
            'attendance_policy_id' => $policy->id,
            'version' => 1,
            'created_at' => now(),
        ]));

        return [$user, $org, $policy, $version];
    }

    /**
     * Authenticate user as tenant context.
     */
    protected function actingAsTenant(User $user, Organization $org): void
    {
        $this->actingAs($user, 'api');
        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
    }

    /**
     * Get a valid clock-in payload.
     *
     * @return array
     */
    protected function getClockInPayload(): array
    {
        return [
            'clock_in_source' => 2, // Web
        ];
    }

    /**
     * Get a valid clock-out payload.
     *
     * @return array
     */
    protected function getClockOutPayload(): array
    {
        return [
            'clock_out_source' => 2, // Web
        ];
    }

    /**
     * Proves that an authenticated employee can clock in and that the system
     * correctly creates both an attendance_day and attendance_session record.
     */
    public function test_employee_can_clock_in(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response->assertStatus(201);

        $this->assertDatabaseHas('attendance_sessions', [
            'clock_in_source' => 2,
        ]);

        $this->assertDatabaseHas('attendance_days', [
            'user_id' => $user->id,
            'organization_id' => $org->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => AttendanceStatus::Incomplete->value,
        ]);
    }

    /**
     * Proves that the attendance_policy_version_id is correctly stamped
     * on the attendance_day record at first clock-in, establishing version
     * isolation at the operational level.
     */
    public function test_clock_in_stamps_policy_version_on_attendance_day(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $this->assertDatabaseHas('attendance_days', [
            'user_id' => $user->id,
            'organization_id' => $org->id,
            'attendance_policy_version_id' => $version->id,
        ]);
    }

    /**
     * Proves that the system prevents double clock-in by throwing
     * AlreadyClockedInException when a session is already open.
     */
    public function test_cannot_clock_in_twice_without_clocking_out(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response = $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response->assertStatus(409)
            ->assertJsonPath('error_code', 'ALREADY_CLOCKED_IN');
    }

    /**
     * Proves that an employee can successfully clock out from an active session.
     */
    public function test_employee_can_clock_out(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response = $this->postJson('/api/v1/attendance/clock-out', $this->getClockOutPayload());

        $response->assertStatus(200);

        $session = AttendanceSession::first();
        $this->assertNotNull($session->clock_out_at);
    }

    /**
     * Proves that after clock-out, the AttendanceDayComputationService correctly
     * updates the attendance_day status to Present when required minutes are met.
     */
    public function test_clock_out_updates_attendance_day_status_to_present(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
            'required_daily_minutes' => 1,
        ]);
        $this->actingAsTenant($user, $org);

        // Clock in
        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        // Backdate the session to 30 minutes ago
        $session = AttendanceSession::first();
        $session->update(['clock_in_at' => Carbon::now()->subMinutes(30)]);

        // Clock out
        $response = $this->postJson('/api/v1/attendance/clock-out', $this->getClockOutPayload());
        $response->assertStatus(200);

        $day = AttendanceDay::first();
        $this->assertEquals(AttendanceStatus::Present->value, $day->getRawOriginal('attendance_status'));
        $this->assertGreaterThan(0, $day->total_work_minutes);
    }

    /**
     * Proves that the computation service correctly identifies a half-day
     * when the employee works at least half but less than the full required minutes.
     */
    public function test_attendance_day_status_is_half_day_when_half_required_minutes_met(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
            'required_daily_minutes' => 480,
        ]);

        // Create attendance day manually
        $day = AttendanceDay::create([
            'user_id' => $user->id,
            'organization_id' => $org->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => AttendanceStatus::Incomplete->value,
            'compliance_status' => \App\Enums\Attendance\ComplianceStatus::Pending->value,
            'attendance_policy_version_id' => $version->id,
            'approval_flow_snapshot' => $version->approval_flow->value,
            'total_work_minutes' => 0,
            'total_break_minutes' => 0,
            'total_sessions' => 0,
            'late_minutes' => 0,
            'early_exit_minutes' => 0,
            'overtime_minutes' => 0,
        ]);

        // Create a session with exactly 240 minutes (half of 480)
        AttendanceSession::create([
            'attendance_day_id' => $day->id,
            'clock_in_at' => Carbon::today()->setHour(9)->setMinute(0),
            'clock_out_at' => Carbon::today()->setHour(13)->setMinute(0),
            'clock_in_source' => 2,
            'clock_out_source' => 2,
            'is_suspicious' => false,
        ]);

        // Call recompute directly
        $computationService = app(AttendanceDayComputationService::class);
        $computationService->recompute($day, $version);

        $day->refresh();
        $this->assertEquals(AttendanceStatus::HalfDay->value, $day->getRawOriginal('attendance_status'));
    }

    /**
     * Proves that late_minutes are correctly calculated in Strict mode
     * when the employee clocks in after the grace period.
     */
    public function test_late_minutes_calculated_in_strict_mode(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
            'attendance_mode' => 1, // Strict
            'shift_start_time' => '09:00:00',
            'grace_late_minutes' => 15,
        ]);

        $day = AttendanceDay::create([
            'user_id' => $user->id,
            'organization_id' => $org->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => AttendanceStatus::Incomplete->value,
            'compliance_status' => \App\Enums\Attendance\ComplianceStatus::Pending->value,
            'attendance_policy_version_id' => $version->id,
            'approval_flow_snapshot' => $version->approval_flow->value,
            'total_work_minutes' => 0,
            'total_break_minutes' => 0,
            'total_sessions' => 0,
            'late_minutes' => 0,
            'early_exit_minutes' => 0,
            'overtime_minutes' => 0,
        ]);

        // Clock in at 09:30 (30 minutes late, 15 min past grace)
        AttendanceSession::create([
            'attendance_day_id' => $day->id,
            'clock_in_at' => Carbon::today()->setHour(9)->setMinute(30),
            'clock_out_at' => Carbon::today()->setHour(18)->setMinute(0),
            'clock_in_source' => 2,
            'clock_out_source' => 2,
            'is_suspicious' => false,
        ]);

        $computationService = app(AttendanceDayComputationService::class);
        $computationService->recompute($day, $version);

        $day->refresh();
        $this->assertEquals(30, $day->late_minutes);
    }

    /**
     * Proves that late_minutes are always 0 in Flexible mode,
     * even when the clock-in is after the shift start time.
     */
    public function test_no_late_minutes_in_flexible_mode(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
            'attendance_mode' => 2, // Flexible
            'shift_start_time' => '09:00:00',
            'grace_late_minutes' => 15,
        ]);

        $day = AttendanceDay::create([
            'user_id' => $user->id,
            'organization_id' => $org->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => AttendanceStatus::Incomplete->value,
            'compliance_status' => \App\Enums\Attendance\ComplianceStatus::Pending->value,
            'attendance_policy_version_id' => $version->id,
            'approval_flow_snapshot' => $version->approval_flow->value,
            'total_work_minutes' => 0,
            'total_break_minutes' => 0,
            'total_sessions' => 0,
            'late_minutes' => 0,
            'early_exit_minutes' => 0,
            'overtime_minutes' => 0,
        ]);

        AttendanceSession::create([
            'attendance_day_id' => $day->id,
            'clock_in_at' => Carbon::today()->setHour(9)->setMinute(30),
            'clock_out_at' => Carbon::today()->setHour(18)->setMinute(0),
            'clock_in_source' => 2,
            'clock_out_source' => 2,
            'is_suspicious' => false,
        ]);

        $computationService = app(AttendanceDayComputationService::class);
        $computationService->recompute($day, $version);

        $day->refresh();
        $this->assertEquals(0, $day->late_minutes);
    }

    /**
     * Proves that the system blocks a second clock-in after clock-out
     * when the policy disallows multiple sessions.
     */
    public function test_multiple_sessions_blocked_when_policy_disallows(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
            'allow_multiple_sessions' => false,
        ]);
        $this->actingAsTenant($user, $org);

        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());
        $this->postJson('/api/v1/attendance/clock-out', $this->getClockOutPayload());

        $response = $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'MULTIPLE_SESSIONS_NOT_ALLOWED');
    }

    /**
     * Proves that clock-in is blocked on weekends when the policy
     * has the relevant day in weekend_days.
     */
    public function test_clock_in_blocked_on_weekend(): void
    {
        // Find the next Sunday
        $sunday = Carbon::now()->next(Carbon::SUNDAY);

        Carbon::setTestNow($sunday->setHour(10)->setMinute(0));

        try {
            [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
                'weekend_days' => [7], // 7 = Sunday
                'allow_clock_in_on_holidays' => false,
            ]);
            $this->actingAsTenant($user, $org);

            $response = $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

            $response->assertStatus(422)
                ->assertJsonPath('error_code', 'CLOCK_IN_NOT_ALLOWED_ON_WEEKEND');
        } finally {
            Carbon::setTestNow();
        }
    }

    /**
     * Proves that clock-in is blocked on organization holidays
     * when the policy disallows it.
     */
    public function test_clock_in_blocked_on_holiday(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy([
            'allow_clock_in_on_holidays' => false,
            'weekend_days' => [], // No weekends to avoid interference
        ]);
        $this->actingAsTenant($user, $org);

        OrganizationHoliday::create([
            'organization_id' => $org->id,
            'name' => 'Test Holiday',
            'holiday_date' => Carbon::today()->toDateString(),
            'is_recurring' => false,
            'is_active' => true,
            'created_by' => $user->id,
        ]);

        $response = $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'CLOCK_IN_NOT_ALLOWED_ON_HOLIDAY');
    }

    /**
     * Proves that clock-out without an active session returns
     * the correct error.
     */
    public function test_clock_out_without_active_session_fails(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $response = $this->postJson('/api/v1/attendance/clock-out', $this->getClockOutPayload());

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'NO_ACTIVE_SESSION');
    }

    /**
     * Proves that the today endpoint returns null before any clock-in
     * has occurred.
     */
    public function test_today_endpoint_returns_null_before_any_clock_in(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $response = $this->getJson('/api/v1/attendance/today');

        $response->assertStatus(200)
            ->assertJsonPath('data', null);
    }

    /**
     * Proves that the today endpoint returns the attendance day with
     * sessions after clock-in.
     */
    public function test_today_endpoint_returns_day_with_sessions_after_clock_in(): void
    {
        [$user, $org, $policy, $version] = $this->createOrgWithAttendancePolicy();
        $this->actingAsTenant($user, $org);

        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        $response = $this->getJson('/api/v1/attendance/today');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertNotNull($data);
        $this->assertArrayHasKey('sessions', $data);
        $this->assertCount(1, $data['sessions']);
    }

    /**
     * Proves that multi-tenant isolation prevents one organization's user
     * from seeing another organization's attendance records.
     */
    public function test_organization_isolation_prevents_cross_org_attendance(): void
    {
        [$userA, $orgA, $policyA, $versionA] = $this->createOrgWithAttendancePolicy();
        [$userB, $orgB, $policyB, $versionB] = $this->createOrgWithAttendancePolicy();

        // Clock in as org A user
        $this->actingAsTenant($userA, $orgA);
        $this->postJson('/api/v1/attendance/clock-in', $this->getClockInPayload());

        // Authenticate as org B user
        $this->actingAsTenant($userB, $orgB);
        $response = $this->getJson('/api/v1/attendance/today');

        $response->assertStatus(200)
            ->assertJsonPath('data', null);
    }
}
