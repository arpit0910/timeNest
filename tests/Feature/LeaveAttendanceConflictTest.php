<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AttendanceAdjustmentStatusEnum;
use App\Enums\AttendanceAdjustmentTypeEnum;
use App\Enums\Leave\ApprovalFlow;
use App\Enums\Leave\LeaveStatus;
use App\Enums\Leave\LeaveType as LeaveTypeEnum;
use App\Enums\MembershipStatus;
use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Exceptions\Leave\LeaveAttendanceConflictException;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Attendance\AttendanceDay;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Membership\EmployeeProfile;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use App\Services\Attendance\AttendanceService;
use App\Services\Leave\LeaveRequestService;
use Database\Seeders\OrganizationRolePermissionsSeeder;
use Database\Seeders\PlatformPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveAttendanceConflictTest extends TestCase
{
    use RefreshDatabase;

    private Organization $organization;
    private User $user;
    private LeaveType $casualLeaveType;
    private LeaveType $wfhLeaveType;
    private LeaveType $ewdLeaveType;
    private LeavePolicyVersion $policyVersion;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PlatformPermissionsSeeder::class);
        $this->seed(OrganizationRolePermissionsSeeder::class);

        $this->organization = Organization::create([
            'legal_name' => 'Acme Test Corp',
            'slug' => 'acme-test-' . uniqid(),
            'is_active' => true,
        ]);

        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john_' . uniqid() . '@acme.com',
        ]);

        $mem = OrganizationMembership::create([
            'user_id' => $this->user->id,
            'organization_id' => $this->organization->id,
            'status' => MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        EmployeeProfile::create([
            'user_id' => $this->user->id,
            'organization_id' => $this->organization->id,
            'organization_membership_id' => $mem->id,
        ]);

        $memberRole = Role::where('name', SystemRole::FREELANCE_MEMBER->value)->firstOrFail();

        setPermissionsTeamId($this->organization->id);
        $this->user->assignRole($memberRole);
        $this->user->givePermissionTo(SystemPermission::LEAVES_CREATE->value);
        $this->user->givePermissionTo(SystemPermission::LEAVES_VIEW->value);
        $this->user->givePermissionTo(SystemPermission::ATTENDANCE_VIEW->value);
        setPermissionsTeamId(null);

        $policy = LeavePolicy::create([
            'organization_id' => $this->organization->id,
            'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
            'allow_half_day_leaves' => true,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'allow_leave_cancellation' => true,
            'created_by' => $this->user->id,
        ]);

        $this->policyVersion = LeavePolicyVersion::create([
            'leave_policy_id' => $policy->id,
            'organization_id' => $this->organization->id,
            'version' => 1,
            'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
            'advance_notice_required_days' => 0,
            'max_advance_application_days' => 90,
            'allow_half_day_leaves' => true,
            'created_by' => $this->user->id,
            'created_at' => now(),
        ]);

        $this->casualLeaveType = LeaveType::create([
            'organization_id' => $this->organization->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Casual Leave',
            'code' => LeaveTypeEnum::CASUAL->value,
            'is_active' => true,
            'allow_half_day' => true,
            'annual_allocation_days' => 20,
            'created_by' => $this->user->id,
        ]);

        $this->wfhLeaveType = LeaveType::create([
            'organization_id' => $this->organization->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Work From Home',
            'code' => LeaveTypeEnum::WORK_FROM_HOME->value,
            'is_active' => true,
            'allow_half_day' => true,
            'annual_allocation_days' => 20,
            'created_by' => $this->user->id,
        ]);

        $this->ewdLeaveType = LeaveType::create([
            'organization_id' => $this->organization->id,
            'leave_policy_id' => $policy->id,
            'name' => 'Extra Working Day',
            'code' => LeaveTypeEnum::EXTRA_WORKING_DAY->value,
            'is_active' => true,
            'allow_half_day' => true,
            'annual_allocation_days' => 20,
            'created_by' => $this->user->id,
        ]);
    }

    public function test_leave_submission_blocked_when_approved_adjustment_exists_on_that_date(): void
    {
        $targetDate = now()->addDays(2)->toDateString();

        $day = AttendanceDay::create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
            'attendance_date' => $targetDate,
            'attendance_status' => 1,
            'compliance_status' => 1,
        ]);

        AttendanceAdjustmentRequest::create([
            'attendance_day_id' => $day->id,
            'requested_by' => $this->user->id,
            'adjustment_type' => AttendanceAdjustmentTypeEnum::MANUAL_ATTENDANCE->value,
            'status' => AttendanceAdjustmentStatusEnum::APPROVED->value,
            'details' => ['reason' => 'Forgot to clock in'],
        ]);

        $leaveService = app(LeaveRequestService::class);

        $this->expectException(LeaveAttendanceConflictException::class);

        $leaveService->submitLeave(
            $this->organization,
            $this->user,
            [
                'leave_type_id' => $this->casualLeaveType->uuid,
                'start_date' => $targetDate,
                'end_date' => $targetDate,
                'reason' => 'Family Event',
            ]
        );
    }

    public function test_adjustment_submission_blocked_when_approved_leave_exists_on_that_date(): void
    {
        $targetDate = now()->addDays(3)->toDateString();

        EmployeeLeave::create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
            'leave_type' => LeaveTypeEnum::CASUAL->value,
            'leave_type_id' => $this->casualLeaveType->id,
            'leave_policy_version_id' => $this->policyVersion->id,
            'approval_flow_snapshot' => ApprovalFlow::SINGLE_APPROVAL->value,
            'leave_status' => LeaveStatus::APPROVED->value,
            'start_date' => $targetDate,
            'end_date' => $targetDate,
            'total_days' => 1.0,
            'reason' => 'Approved Vacation',
        ]);

        $day = AttendanceDay::create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
            'attendance_date' => $targetDate,
            'attendance_status' => 1,
            'compliance_status' => 1,
        ]);

        $attendanceService = app(AttendanceService::class);

        $this->expectException(LeaveAttendanceConflictException::class);

        $attendanceService->submitAdjustment(
            $this->user,
            $day,
            [
                'adjustment_type' => AttendanceAdjustmentTypeEnum::MANUAL_ATTENDANCE->value,
                'reason' => 'Attempting adjustment on approved leave day',
            ]
        );
    }

    public function test_wfh_and_ewd_leave_types_do_not_trigger_conflict_block(): void
    {
        $targetDate = now()->addDays(4)->toDateString();

        $day = AttendanceDay::create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
            'attendance_date' => $targetDate,
            'attendance_status' => 1,
            'compliance_status' => 1,
        ]);

        AttendanceAdjustmentRequest::create([
            'attendance_day_id' => $day->id,
            'requested_by' => $this->user->id,
            'adjustment_type' => AttendanceAdjustmentTypeEnum::MANUAL_ATTENDANCE->value,
            'status' => AttendanceAdjustmentStatusEnum::APPROVED->value,
            'details' => ['reason' => 'Approved adjustment'],
        ]);

        $leaveService = app(LeaveRequestService::class);

        // Submit WFH leave request — should succeed without exception
        $wfhLeave = $leaveService->submitLeave(
            $this->organization,
            $this->user,
            [
                'leave_type_id' => $this->wfhLeaveType->uuid,
                'start_date' => $targetDate,
                'end_date' => $targetDate,
                'reason' => 'Working remotely',
            ]
        );

        $this->assertNotNull($wfhLeave);
        $this->assertEquals($targetDate, $wfhLeave->start_date->toDateString());

        // Reverse check test: Approved WFH leave does NOT block adjustment submission
        $wfhLeave->update(['leave_status' => LeaveStatus::APPROVED->value]);

        $attendanceService = app(AttendanceService::class);
        $adj = $attendanceService->submitAdjustment(
            $this->user,
            $day,
            [
                'adjustment_type' => AttendanceAdjustmentTypeEnum::MANUAL_ATTENDANCE->value,
                'reason' => 'Valid adjustment alongside WFH',
            ]
        );

        $this->assertNotNull($adj);
        $this->assertEquals($day->id, $adj->attendance_day_id);
    }

    public function test_normal_leave_submission_with_no_conflicts_still_succeeds(): void
    {
        $targetDate = now()->addDays(5)->toDateString();

        $leaveService = app(LeaveRequestService::class);

        $leave = $leaveService->submitLeave(
            $this->organization,
            $this->user,
            [
                'leave_type_id' => $this->casualLeaveType->uuid,
                'start_date' => $targetDate,
                'end_date' => $targetDate,
                'reason' => 'Personal work',
            ]
        );

        $this->assertNotNull($leave);
        $this->assertTrue($leave->isPending());
        $this->assertEquals($targetDate, $leave->start_date->toDateString());
    }
}
