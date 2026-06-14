<?php

declare(strict_types=1);

namespace Tests\Feature\Leave;

use App\Enums\Leave\ApprovalFlow;
use App\Enums\Leave\LeaveStatus;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private User $employee;
    private User $manager;
    private User $hr;
    private Organization $organization;
    private LeavePolicy $policy;
    private LeavePolicyVersion $policyVersion;
    private LeaveType $leaveType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner',
            'email' => 'owner' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
        ]);
        $this->employee = User::create([
            'name' => 'Employee',
            'email' => 'employee' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
        ]);
        $this->manager = User::create([
            'name' => 'Manager',
            'email' => 'manager' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
        ]);
        $this->hr = User::create([
            'name' => 'HR',
            'email' => 'hr' . uniqid() . '@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->organization = Organization::create([
            'legal_name' => 'Test Organization',
            'slug' => 'test-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::Organization->value,
            'is_active' => true,
        ]);

        $attachData = fn() => [
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'status' => 'active',
            'joined_at' => now(),
        ];

        $this->organization->users()->attach($this->owner->id, $attachData());
        $this->organization->users()->attach($this->employee->id, $attachData());
        $this->organization->users()->attach($this->manager->id, $attachData());
        $this->organization->users()->attach($this->hr->id, $attachData());

        \Illuminate\Support\Facades\Gate::define('leave.request.create', fn ($u) => true);
        \Illuminate\Support\Facades\Gate::define('leave.request.approve', fn ($u) => in_array($u->id, [$this->manager->id, $this->hr->id]));
        \Illuminate\Support\Facades\Gate::define('leave.request.view_all', fn ($u) => in_array($u->id, [$this->manager->id, $this->hr->id]));

        $this->policy = LeavePolicy::create([
            'organization_id' => $this->organization->id,
            'approval_flow' => ApprovalFlow::SingleApproval->value,
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
            'created_by' => $this->owner->id,
        ]);

        $this->policyVersion = LeavePolicyVersion::create([
            'leave_policy_id' => $this->policy->id,
            'organization_id' => $this->organization->id,
            'version' => 1,
            'approval_flow' => ApprovalFlow::SingleApproval->value,
            'advance_notice_required_days' => 1,
            'max_advance_application_days' => 30,
            'allow_half_day_leaves' => true,
            'document_required_after_days' => 3,
            'created_by' => $this->owner->id,
            'created_at' => now(),
        ]);

        $this->leaveType = LeaveType::create([
            'organization_id' => $this->organization->id,
            'leave_policy_id' => $this->policy->id,
            'name' => 'Casual Leave',
            'is_active' => true,
            'code' => 1, // Casual
            'allow_half_day' => true,
            'annual_allocation_days' => 20,
            'created_by' => $this->owner->id,
        ]);
    }

    protected function actingAsTenant(User $user, Organization $org)
    {
        $this->actingAs($user, 'api');
        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
        return $this;
    }

    public function test_1_can_submit_leave_request(): void
    {
        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(2)->toDateString(),
            'reason' => 'Family vacation trip',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('employee_leaves', [
            'user_id' => $this->employee->id,
            'leave_status' => LeaveStatus::Pending->value,
        ]);
    }

    public function test_2_cannot_submit_without_advance_notice(): void
    {
        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::today()->toDateString(),
            'end_date' => Carbon::today()->addDays(2)->toDateString(),
            'reason' => 'Family vacation trip',
        ]);

        $response->assertStatus(422);
    }

    public function test_3_cannot_submit_overlapping_leave(): void
    {
        $this->test_1_can_submit_leave_request();

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(1)->toDateString(),
            'reason' => 'Another vacation trip',
        ]);

        $response->assertStatus(422);
    }

    public function test_4_auto_approval_flow(): void
    {
        $this->policyVersion->update(['approval_flow' => ApprovalFlow::Auto->value]);

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(2)->toDateString(),
            'reason' => 'Family vacation trip',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('employee_leaves', [
            'user_id' => $this->employee->id,
            'leave_status' => LeaveStatus::AutoApproved->value,
        ]);
    }

    public function test_5_manager_can_approve_leave(): void
    {
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();

        $response = $this->actingAsTenant($this->manager, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/approve", [
            'remarks' => 'Approved, have fun!',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(LeaveStatus::Approved, $leave->fresh()->leave_status);
    }

    public function test_6_employee_cannot_approve_own_leave(): void
    {
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/approve", [
            'remarks' => 'Approved!',
        ]);

        $response->assertStatus(403);
    }

    public function test_7_manager_can_reject_leave(): void
    {
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();

        $response = $this->actingAsTenant($this->manager, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/reject", [
            'rejection_reason' => 'Project deadline incoming',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(LeaveStatus::Rejected, $leave->fresh()->leave_status);
    }

    public function test_8_employee_can_cancel_pending_leave(): void
    {
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/cancel", [
            'reason' => 'Changed my mind',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(LeaveStatus::Cancelled, $leave->fresh()->leave_status);
    }

    public function test_9_manager_cannot_cancel_employee_leave(): void
    {
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();

        $response = $this->actingAsTenant($this->manager, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/cancel", [
            'reason' => 'I am cancelling this',
        ]);

        $response->assertStatus(403);
    }

    public function test_10_multilevel_approval_requires_two_steps(): void
    {
        $this->policyVersion->update(['approval_flow' => ApprovalFlow::MultiLevelApproval->value]);
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();

        $this->actingAsTenant($this->manager, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/approve", [
            'remarks' => 'Manager approved',
        ])->assertStatus(200);

        $this->assertEquals(LeaveStatus::Pending, $leave->fresh()->leave_status);
        $this->assertNotNull($leave->fresh()->approved_at);

        $this->actingAsTenant($this->hr, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/approve", [
            'remarks' => 'HR approved',
        ])->assertStatus(200);

        $this->assertEquals(LeaveStatus::Approved, $leave->fresh()->leave_status);
        $this->assertNotNull($leave->fresh()->second_approved_at);
    }

    public function test_11_insufficient_balance_returns_error(): void
    {
        $this->leaveType->update(['annual_allocation_days' => 1]);

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(5)->toDateString(),
            'reason' => 'Going away',
        ]);

        $response->assertStatus(422);
    }

    public function test_12_half_day_leave_counts_as_half(): void
    {
        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->toDateString(),
            'is_half_day' => true,
            'reason' => 'Doctor appointment',
        ]);

        $response->assertStatus(201);
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();
        $this->assertEquals(0.5, $leave->total_days);
    }

    public function test_13_half_day_leave_fails_on_multiple_dates(): void
    {
        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(1)->toDateString(),
            'is_half_day' => true,
            'reason' => 'Doctor appointment',
        ]);

        $response->assertStatus(422);
    }

    public function test_14_cannot_apply_inactive_leave_type(): void
    {
        $this->leaveType->update(['is_active' => false]);
        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(1)->toDateString(),
            'reason' => 'Vacation',
        ]);

        $response->assertStatus(422);
    }

    public function test_15_document_required_if_exceeds_days(): void
    {
        $this->policyVersion->update(['document_required_after_days' => 1]);

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(3)->toDateString(),
            'reason' => 'Long vacation',
        ]);

        $response->assertStatus(422);
    }

    public function test_16_document_provided_passes_validation(): void
    {
        $this->policyVersion->update(['document_required_after_days' => 1]);

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests", [
            'leave_type_id' => $this->leaveType->uuid,
            'start_date' => Carbon::tomorrow()->toDateString(),
            'end_date' => Carbon::tomorrow()->addDays(3)->toDateString(),
            'reason' => 'Long vacation',
            'attachment_path' => 'docs/proof.pdf',
        ]);

        $response->assertStatus(201);
    }

    public function test_17_get_leave_requests_paginated(): void
    {
        $this->test_1_can_submit_leave_request();

        $response = $this->actingAsTenant($this->employee, $this->organization)->getJson("/api/v1/leave-requests");
        
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['data' => [['uuid']]]]);
    }

    public function test_18_get_balances(): void
    {
        $this->test_1_can_submit_leave_request();

        $response = $this->actingAsTenant($this->employee, $this->organization)->getJson("/api/v1/leave-requests/balances");
        
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_19_cannot_cancel_approved_leave_past_deadline(): void
    {
        $this->policy->update([
            'allow_leave_cancellation' => true,
            'cancellation_before_hours' => 24
        ]);

        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();
        $leave->update([
            'leave_status' => LeaveStatus::Approved->value,
            'start_date' => Carbon::now()->addHours(12)->toDateString(),
        ]);

        $response = $this->actingAsTenant($this->employee, $this->organization)->postJson("/api/v1/leave-requests/{$leave->uuid}/cancel", [
            'reason' => 'Changed my mind',
        ]);

        $response->assertStatus(422);
    }

    public function test_20_auto_approve_system_cron(): void
    {
        $this->policy->update(['auto_approve_after_hours' => 48]);
        
        $this->test_1_can_submit_leave_request();
        $leave = EmployeeLeave::where('user_id', $this->employee->id)->first();
        $leave->update(['created_at' => now()->subHours(50)]);

        $service = app(\App\Services\Leave\LeaveRequestService::class);
        $count = $service->processAutoApprovals($this->organization);

        $this->assertEquals(1, $count);
        $this->assertEquals(LeaveStatus::Approved, $leave->fresh()->leave_status);
    }
}
