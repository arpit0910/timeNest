<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Actions\IssueJwtAction;
use App\Enums\AttendanceAdjustmentStatusEnum;
use App\Enums\AttendanceAdjustmentTypeEnum;
use App\Enums\AttendanceSessionSourceEnum;
use App\Enums\LeaveStatusEnum;
use App\Enums\LeaveTypeEnum;
use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\CorporationHoliday;
use App\Models\Attendance\EmployeeLeave;
use App\Models\Auth\User;
use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Rbac\Role;
use App\Services\Attendance\AttendancePolicyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class AttendanceCoreTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Corporation $corporation;
    private CorpMembership $membership;
    private EmployeeProfile $employeeProfile;
    private Branch $branch;
    private string $token;
    private AttendancePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create Corporation
        $this->corporation = Corporation::create([
            'legal_name' => 'Test Corp',
            'slug' => 'test-corp',
            'is_active' => true,
            'is_verified' => true,
        ]);

        // 2. Create Role & Permission
        $role = Role::create([
            'name' => SystemRole::Employee->value,
            'guard_name' => 'api',
            'corporation_id' => null,
            'is_system_role' => true,
        ]);

        \App\Models\Rbac\Permission::create([
            'name' => \App\Enums\SystemPermission::LeavesApprove->value,
            'guard_name' => 'api',
        ]);

        // 3. Create User & Membership
        $this->user = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
            'timezone' => 'Asia/Kolkata',
        ]);

        $this->membership = CorpMembership::create([
            'user_id' => $this->user->id,
            'corporation_id' => $this->corporation->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($this->corporation->id);
        $this->user->assignRole($role);
        setPermissionsTeamId(null);

        // 4. Create Branch (Bangalore: 12.9716, 77.5946)
        $this->branch = Branch::create([
            'corporation_id' => $this->corporation->id,
            'name' => 'Bangalore HQ',
            'code' => 'BLR01',
            'latitude' => 12.9716,
            'longitude' => 77.5946,
            'geo_fence_radius' => 200, // 200 meters
            'timezone' => 'Asia/Kolkata',
            'is_active' => true,
        ]);

        // 5. Create Employee Profile
        $this->employeeProfile = EmployeeProfile::create([
            'user_id' => $this->user->id,
            'corporation_id' => $this->corporation->id,
            'corp_membership_id' => $this->membership->id,
            'employee_code' => 'EMP001',
            'branch_id' => $this->branch->id,
            'is_active' => true,
        ]);

        // 6. Create Policy using service
        $policyService = app(AttendancePolicyService::class);
        $this->policy = $policyService->createDefaultPolicy($this->corporation, $this->user);

        // 7. Issue Auth Token
        $issueJwtAction = app(IssueJwtAction::class);
        $this->token = $issueJwtAction->issueAccessToken(
            $this->user,
            $this->corporation,
            \App\Enums\Guard::Corp,
            SystemRole::Employee->value
        );
    }

    /**
     * Set up auth headers.
     */
    private function authHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->token}",
            'X-Corporation-Uuid' => $this->corporation->uuid,
        ];
    }

    /**
     * Test successful clock-in inside geofence.
     */
    public function test_successful_clock_in(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 12.9717, // ~15 meters away
                'longitude' => 77.5947,
                'accuracy' => 10.0,
                'device_id' => 'device-123',
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'uuid',
                    'clock_in_at',
                    'clock_in_ip',
                    'clock_in_source',
                    'is_suspicious',
                ],
            ]);

        $this->assertDatabaseHas('attendance_sessions', [
            'clock_in_device_id' => 'device-123',
            'is_suspicious' => false,
        ]);
    }

    /**
     * Test geofence rejection when clocking in from outside geofence.
     */
    public function test_geofence_rejection(): void
    {
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 13.0353, // ~7 km away
                'longitude' => 77.5988,
                'accuracy' => 10.0,
                'device_id' => 'device-123',
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('error_code', 'OUTSIDE_GEOFENCE');
    }

    /**
     * Test approved WFH bypasses geofence check.
     */
    public function test_wfh_clock_in_bypasses_geofence(): void
    {
        // Apply and approve WFH leave for today
        $leave = EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::WorkFromHome->value,
            'leave_status' => LeaveStatusEnum::Approved->value,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'total_days' => 1,
            'reason' => 'Remote work day',
            'approved_by' => $this->user->id,
            'approved_at' => now(),
        ]);

        // Clock in from far away coordinates (outside geofence)
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 13.0353,
                'longitude' => 77.5988,
                'accuracy' => 10.0,
                'device_id' => 'device-123',
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        // Should succeed without geofence validation error
        $response->assertCreated()
            ->assertJsonPath('success', true);
    }

    /**
     * Test holiday clock-in rejection when policy blocks holiday clock-in.
     */
    public function test_holiday_rejection(): void
    {
        // 1. Create a holiday for today
        CorporationHoliday::create([
            'corporation_id' => $this->corporation->id,
            'branch_id' => $this->branch->id,
            'name' => 'Independence Day',
            'holiday_date' => now()->toDateString(),
            'is_active' => true,
        ]);

        // 2. Make sure policy blocks clocking in on holiday
        $this->policy->update(['allow_clock_in_on_holidays' => false]);
        app(AttendancePolicyService::class)->invalidateCache($this->corporation->id);

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'accuracy' => 5.0,
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'HOLIDAY_CLOCK_IN_BLOCKED');
    }

    /**
     * Test active EWD allows holiday clock-in even if blocked.
     */
    public function test_ewd_allowance(): void
    {
        // Create holiday
        CorporationHoliday::create([
            'corporation_id' => $this->corporation->id,
            'branch_id' => $this->branch->id,
            'name' => 'Labor Day',
            'holiday_date' => now()->toDateString(),
            'is_active' => true,
        ]);

        // Block holiday clock-ins
        $this->policy->update(['allow_clock_in_on_holidays' => false]);
        app(AttendancePolicyService::class)->invalidateCache($this->corporation->id);

        // Approve EWD leave for today
        EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::ExtraWorkingDay->value,
            'leave_status' => LeaveStatusEnum::Approved->value,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'total_days' => 1,
            'reason' => 'Weekend deployment shift',
            'approved_by' => $this->user->id,
            'approved_at' => now(),
        ]);

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'accuracy' => 5.0,
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        $response->assertCreated()
            ->assertJsonPath('success', true);
    }

    /**
     * Test duplicate clock-in rejection when user has an active clock-in session.
     */
    public function test_duplicate_clock_in_rejected(): void
    {
        // First clock-in
        $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'accuracy' => 5.0,
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        // Duplicate clock-in
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'accuracy' => 5.0,
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'ACTIVE_SESSION_EXISTS');
    }

    /**
     * Test clock-out calculates correct work duration and late minutes.
     */
    public function test_clock_out_calculates_duration_and_late(): void
    {
        // Freeze time so we can simulate clock-in at 09:30:00 (which is 30 mins late in strict mode)
        Carbon::setTestNow(Carbon::parse(now()->toDateString() . ' 09:30:00', 'Asia/Kolkata')->tz('UTC'));

        // Regenerate token to prevent expiration error due to frozen past time
        $issueJwtAction = app(IssueJwtAction::class);
        $this->token = $issueJwtAction->issueAccessToken(
            $this->user,
            $this->corporation,
            \App\Enums\Guard::Corp,
            SystemRole::Employee->value
        );

        $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-in', [
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'accuracy' => 5.0,
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        // Advance time by 5 hours (300 minutes) to clock out
        Carbon::setTestNow(Carbon::now()->addHours(5));

        // Regenerate token to prevent expiration error for the clock-out request
        $this->token = $issueJwtAction->issueAccessToken(
            $this->user,
            $this->corporation,
            \App\Enums\Guard::Corp,
            SystemRole::Employee->value
        );

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/clock-out', [
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'accuracy' => 5.0,
                'source' => AttendanceSessionSourceEnum::Mobile->value,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true);

        // Fetch Day Summary
        $day = AttendanceDay::where('user_id', $this->user->id)->first();
        $this->assertEquals(300, $day->total_work_minutes);
        $this->assertEquals(30, $day->late_minutes);

        Carbon::setTestNow(); // Clean up
    }

    /**
     * Test leave overlap validation.
     */
    public function test_leave_overlap_rejection(): void
    {
        // Approve casual leave for next week
        $nextMonday = Carbon::now()->next(Carbon::MONDAY);
        $nextFriday = $nextMonday->copy()->next(Carbon::FRIDAY);

        $nextMondayStr = $nextMonday->toDateString();
        $nextFridayStr = $nextFriday->toDateString();

        EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::Casual->value,
            'leave_status' => LeaveStatusEnum::Approved->value,
            'start_date' => $nextMondayStr,
            'end_date' => $nextFridayStr,
            'total_days' => 5,
            'reason' => 'Vacation',
        ]);

        // Request overlapping leave
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/leaves', [
                'leave_type' => LeaveTypeEnum::Sick->value,
                'start_date' => $nextMondayStr,
                'end_date' => $nextMondayStr, // Overlaps
                'reason' => 'Sick checkup',
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'LEAVE_OVERLAP');
    }

    /**
     * Test attendance adjustment submission and approval flow.
     */
    public function test_adjustment_flow(): void
    {
        // 1. Create a dummy attendance day and session
        $day = AttendanceDay::create([
            'user_id' => $this->user->id,
            'corporation_id' => $this->corporation->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::Incomplete->value,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::Pending->value,
        ]);

        $session = $day->attendanceSessions()->create([
            'clock_in_at' => Carbon::now()->subHours(4),
            'clock_out_at' => Carbon::now()->subHours(2), // 2 hours duration
            'clock_in_source' => AttendanceSessionSourceEnum::Web->value,
        ]);

        // 2. Submit adjustment request for clock_out correction to make it 4 hours
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/v1/corp/attendance/adjustments', [
                'attendance_day_id' => $day->id,
                'attendance_session_id' => $session->id,
                'adjustment_type' => AttendanceAdjustmentTypeEnum::ClockOutCorrection->value,
                'clock_in_at' => $session->clock_in_at->toIso8601String(),
                'clock_out_at' => Carbon::now()->toIso8601String(), // corrected clock out
                'reason' => 'Forgot to clock out on time',
            ]);

        $response->assertCreated();
        $adjustmentUuid = $response->json('data.uuid');

        // Verify status is pending
        $this->assertDatabaseHas('attendance_adjustment_requests', [
            'uuid' => $adjustmentUuid,
            'status' => AttendanceAdjustmentStatusEnum::Pending->value,
        ]);

        // 3. Approve adjustment
        $approveResponse = $this->withHeaders($this->authHeaders())
            ->putJson("/api/v1/corp/attendance/adjustments/{$adjustmentUuid}/approve");

        $approveResponse->assertOk();

        // 4. Verify day aggregates recalculated
        $day->refresh();
        $this->assertEquals(240, $day->total_work_minutes); // Should be 4 hours now

        $this->assertDatabaseHas('attendance_adjustment_requests', [
            'uuid' => $adjustmentUuid,
            'status' => AttendanceAdjustmentStatusEnum::Approved->value,
        ]);
    }

    public function test_leave_status_transition_success(): void
    {
        // 1. Create a Manager user and assign role with leaves.approve permission
        $managerUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $managerMembership = CorpMembership::create([
            'user_id' => $managerUser->id,
            'corporation_id' => $this->corporation->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);

        $managerRole = Role::create([
            'name' => SystemRole::HrManager->value,
            'guard_name' => 'api',
            'corporation_id' => null,
            'is_system_role' => true,
        ]);

        $permission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::LeavesApprove->value)->first();

        $managerRole->givePermissionTo($permission);

        setPermissionsTeamId($this->corporation->id);
        $managerUser->assignRole($managerRole);
        setPermissionsTeamId(null);

        // Create manager auth token
        $issueJwtAction = app(IssueJwtAction::class);
        $managerToken = $issueJwtAction->issueAccessToken(
            $managerUser,
            $this->corporation,
            \App\Enums\Guard::Corp,
            SystemRole::HrManager->value
        );

        $managerHeaders = [
            'Authorization' => "Bearer {$managerToken}",
            'X-Corporation-Uuid' => $this->corporation->uuid,
        ];

        // 2. Apply for leave as the regular Employee user
        $leave = EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::Casual->value,
            'leave_status' => LeaveStatusEnum::Pending->value,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'total_days' => 4.0,
            'reason' => 'Need some rest',
        ]);

        // 3. Manager transitions leave status from Pending to Approved
        $response = $this->withHeaders($managerHeaders)
            ->patchJson("/api/v1/corp/attendance/leaves/{$leave->uuid}/status", [
                'status' => LeaveStatusEnum::Approved->value,
                'remarks' => 'Approved after review',
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.leave_status.value', LeaveStatusEnum::Approved->value);

        // Verify database and status history table
        $this->assertDatabaseHas('employee_leaves', [
            'uuid' => $leave->uuid,
            'leave_status' => LeaveStatusEnum::Approved->value,
            'approved_by' => $managerUser->id,
        ]);

        $this->assertDatabaseHas('leave_status_histories', [
            'employee_leave_id' => $leave->id,
            'old_status' => LeaveStatusEnum::Pending->value,
            'new_status' => LeaveStatusEnum::Approved->value,
            'changed_by' => $managerUser->id,
            'remarks' => 'Approved after review',
        ]);
    }

    public function test_leave_status_transition_invalid(): void
    {
        // 1. Create a Manager user and assign role with leaves.approve permission
        $managerUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        CorpMembership::create([
            'user_id' => $managerUser->id,
            'corporation_id' => $this->corporation->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);

        $managerRole = Role::create([
            'name' => SystemRole::HrManager->value,
            'guard_name' => 'api',
            'corporation_id' => null,
            'is_system_role' => true,
        ]);

        $permission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::LeavesApprove->value)->first();

        $managerRole->givePermissionTo($permission);

        setPermissionsTeamId($this->corporation->id);
        $managerUser->assignRole($managerRole);
        setPermissionsTeamId(null);

        $issueJwtAction = app(IssueJwtAction::class);
        $managerToken = $issueJwtAction->issueAccessToken(
            $managerUser,
            $this->corporation,
            \App\Enums\Guard::Corp,
            SystemRole::HrManager->value
        );

        $managerHeaders = [
            'Authorization' => "Bearer {$managerToken}",
            'X-Corporation-Uuid' => $this->corporation->uuid,
        ];

        // 2. Create an Approved leave
        $leave = EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::Casual->value,
            'leave_status' => LeaveStatusEnum::Approved->value,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'total_days' => 4.0,
            'reason' => 'Need some rest',
        ]);

        // 3. Manager tries to transition from Approved back to Draft (which is invalid)
        $response = $this->withHeaders($managerHeaders)
            ->patchJson("/api/v1/corp/attendance/leaves/{$leave->uuid}/status", [
                'status' => LeaveStatusEnum::Draft->value,
                'remarks' => 'Illegal regression',
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('error_code', 'INVALID_STATUS_TRANSITION');
    }

    public function test_leave_status_transition_unauthorized(): void
    {
        // 1. Create a Pending leave
        $leave = EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::Casual->value,
            'leave_status' => LeaveStatusEnum::Pending->value,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'total_days' => 4.0,
            'reason' => 'Need some rest',
        ]);

        // 2. Regular employee tries to approve their own leave (unauthorized)
        $response = $this->withHeaders($this->authHeaders())
            ->patchJson("/api/v1/corp/attendance/leaves/{$leave->uuid}/status", [
                'status' => LeaveStatusEnum::Approved->value,
                'remarks' => 'Self-approving',
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('error_code', 'UNAUTHORIZED_TRANSITION');
    }

    public function test_leave_status_self_cancellation(): void
    {
        // 1. Create a Pending leave
        $leave = EmployeeLeave::create([
            'corporation_id' => $this->corporation->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::Casual->value,
            'leave_status' => LeaveStatusEnum::Pending->value,
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(5)->toDateString(),
            'total_days' => 4.0,
            'reason' => 'Need some rest',
        ]);

        // 2. Regular employee cancels their own pending leave
        $response = $this->withHeaders($this->authHeaders())
            ->patchJson("/api/v1/corp/attendance/leaves/{$leave->uuid}/status", [
                'status' => LeaveStatusEnum::Cancelled->value,
                'remarks' => 'No longer needed',
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.leave_status.value', LeaveStatusEnum::Cancelled->value);

        $this->assertDatabaseHas('employee_leaves', [
            'uuid' => $leave->uuid,
            'leave_status' => LeaveStatusEnum::Cancelled->value,
            'cancellation_reason' => 'No longer needed',
        ]);

        $this->assertDatabaseHas('leave_status_histories', [
            'employee_leave_id' => $leave->id,
            'old_status' => LeaveStatusEnum::Pending->value,
            'new_status' => LeaveStatusEnum::Cancelled->value,
            'changed_by' => $this->user->id,
            'remarks' => 'No longer needed',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        setPermissionsTeamId(null);
        parent::tearDown();
    }
}
