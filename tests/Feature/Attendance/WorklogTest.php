<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\Attendance\ComplianceStatus;
use App\Enums\Attendance\WorklogStatus;
use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\Worklog\ApprovalFlow;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Worklog\WorklogPolicy;
use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorklogTest extends TestCase
{
    use RefreshDatabase;

    protected function createUserWithOrg(Organization $org): User
    {
        $user = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
        ]);

        $org->users()->attach($user->id, [
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'status' => 'active',
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($org->id);
        $permission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_VIEW->value)->where('guard_name', 'api')->first();
        if ($permission) {
            $user->givePermissionTo($permission);
        }
        
        $approvePermission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_APPROVE->value)->where('guard_name', 'api')->first();
        if ($approvePermission) {
            $user->givePermissionTo($approvePermission);
        }
        
        $approveAnyPermission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_APPROVE_ANY->value)->where('guard_name', 'api')->first();
        if ($approveAnyPermission) {
            $user->givePermissionTo($approveAnyPermission);
        }
        setPermissionsTeamId(null);

        return $user;
    }

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

    protected function createOrgWithWorklogSetup(ApprovalFlow $flow = ApprovalFlow::AUTO): array
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
        ]);

        $organization = Organization::create([
            'legal_name' => 'Test Organization',
            'slug' => 'test-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value ?? 'organization',
            'is_active' => true,
        ]);

        $organization->users()->attach($user->id, [
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // Assign worklog permissions to the user using seeded permissions
        setPermissionsTeamId($organization->id);
        $worklogViewPermission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_VIEW->value)->where('guard_name', 'api')->first();
        $worklogCreatePermission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_CREATE->value)->where('guard_name', 'api')->first();
        $worklogApprovePermission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_APPROVE->value)->where('guard_name', 'api')->first();
        $worklogApproveAnyPermission = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::WORKLOG_APPROVE_ANY->value)->where('guard_name', 'api')->first();
        $user->givePermissionTo($worklogViewPermission, $worklogCreatePermission, $worklogApprovePermission, $worklogApproveAnyPermission);
        setPermissionsTeamId(null);

        $attPolicy = new AttendancePolicy();
        $attPolicy->organization_id = $organization->id;
        $attPolicy->attendance_mode = \App\Enums\Attendance\AttendanceMode::FLEXIBLE ?? 1;
        $attPolicy->approval_flow = \App\Enums\Attendance\ApprovalFlow::AUTO ?? 1;
        $attPolicy->shift_start_time = '09:00:00';
        $attPolicy->shift_end_time = '17:00:00';
        $attPolicy->required_daily_minutes = 480;
        $attPolicy->minimum_session_minutes = 60;
        $attPolicy->grace_late_minutes = 15;
        $attPolicy->allowed_monthly_late_count = 3;
        $attPolicy->allow_early_exit = false;
        $attPolicy->default_break_minutes = 60;
        $attPolicy->max_break_minutes = 60;
        $attPolicy->allow_multiple_sessions = true;
        $attPolicy->allow_clock_in_on_holidays = false;
        $attPolicy->auto_clock_out_enabled = false;
        $attPolicy->overtime_enabled = false;
        $attPolicy->weekend_days = [6, 7];
        $attPolicy->geo_fencing_enabled = false;
        $attPolicy->ip_restriction_enabled = false;
        $attPolicy->strict_worklog_enforcement = true;
        $attPolicy->created_by = $user->id;
        $attPolicy->updated_by = $user->id;
        $attPolicy->save();

        $attPolicyVersion = new AttendancePolicyVersion();
        $attPolicyVersion->attendance_policy_id = $attPolicy->id;
        $attPolicyVersion->version = 1;
        $attPolicyVersion->organization_id = $organization->id;
        $attPolicyVersion->attendance_mode = 1;
        $attPolicyVersion->approval_flow = \App\Enums\Attendance\ApprovalFlow::AUTO;
        $attPolicyVersion->shift_start_time = '09:00:00';
        $attPolicyVersion->shift_end_time = '17:00:00';
        $attPolicyVersion->required_daily_minutes = 480;
        $attPolicyVersion->minimum_session_minutes = 60;
        $attPolicyVersion->grace_late_minutes = 15;
        $attPolicyVersion->allowed_monthly_late_count = 3;
        $attPolicyVersion->allow_early_exit = false;
        $attPolicyVersion->default_break_minutes = 60;
        $attPolicyVersion->max_break_minutes = 60;
        $attPolicyVersion->allow_multiple_sessions = true;
        $attPolicyVersion->allow_clock_in_on_holidays = false;
        $attPolicyVersion->auto_clock_out_enabled = false;
        $attPolicyVersion->overtime_enabled = false;
        $attPolicyVersion->weekend_days = [6, 7];
        $attPolicyVersion->geo_fencing_enabled = false;
        $attPolicyVersion->ip_restriction_enabled = false;
        $attPolicyVersion->strict_worklog_enforcement = true;
        $attPolicyVersion->created_by = $user->id;
        $attPolicyVersion->created_at = now();
        $attPolicyVersion->save();

        $wlPolicy = new WorklogPolicy();
        $wlPolicy->organization_id = $organization->id;
        $wlPolicy->worklog_mode = 1;
        $wlPolicy->approval_flow = $flow;
        $wlPolicy->require_worklog_on_clockout = false;
        $wlPolicy->allow_deferred_submission = true;
        $wlPolicy->submission_window_days = 1;
        $wlPolicy->edit_grace_days = 1;
        $wlPolicy->lock_after_days = 7;
        $wlPolicy->require_description = false;
        $wlPolicy->min_description_length = 0;
        $wlPolicy->require_justification_on_overflow = false;
        $wlPolicy->require_project_mapping = false;
        $wlPolicy->require_task_mapping = false;
        $wlPolicy->allow_multiple_worklogs_per_session = true;
        $wlPolicy->auto_escalate_overdue_logs = false;
        $wlPolicy->billable_tracking_enabled = false;
        $wlPolicy->created_by = $user->id;
        $wlPolicy->updated_by = $user->id;
        $wlPolicy->save();

        $wlPolicyVersion = new WorklogPolicyVersion();
        $wlPolicyVersion->worklog_policy_id = $wlPolicy->id;
        $wlPolicyVersion->version = 1;
        $wlPolicyVersion->organization_id = $organization->id;
        $wlPolicyVersion->worklog_mode = 1;
        $wlPolicyVersion->approval_flow = $flow->value;
        $wlPolicyVersion->require_worklog_on_clockout = false;
        $wlPolicyVersion->allow_deferred_submission = true;
        $wlPolicyVersion->submission_window_days = 1;
        $wlPolicyVersion->edit_grace_days = 1;
        $wlPolicyVersion->lock_after_days = 7;
        $wlPolicyVersion->require_description = false;
        $wlPolicyVersion->min_description_length = 0;
        $wlPolicyVersion->require_justification_on_overflow = false;
        $wlPolicyVersion->require_project_mapping = false;
        $wlPolicyVersion->require_task_mapping = false;
        $wlPolicyVersion->allow_multiple_worklogs_per_session = true;
        $wlPolicyVersion->auto_escalate_overdue_logs = false;
        $wlPolicyVersion->billable_tracking_enabled = false;
        $wlPolicyVersion->created_by = $user->id;
        $wlPolicyVersion->created_at = now();
        $wlPolicyVersion->save();

        $day = new AttendanceDay();
        $day->user_id = $user->id;
        $day->organization_id = $organization->id;
        $day->attendance_date = now()->toDateString();
        $day->attendance_status = \App\Enums\AttendanceStatusEnum::PRESENT;
        $day->compliance_status = \App\Enums\AttendanceComplianceStatusEnum::PENDING;
        $day->attendance_policy_version_id = $attPolicyVersion->id;
        $day->save();

        $session = new AttendanceSession();
        $session->attendance_day_id = $day->id;
        $session->clock_in_at = now()->subHours(2);
        $session->clock_out_at = now()->subHours(1);
        $session->clock_in_source = 1;
        $session->clock_out_source = 1;
        $session->save();

        return [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion];
    }

    protected function getValidWorklogPayload(int $minutes = 30): array
    {
        return [
            'logged_minutes' => $minutes,
            'description' => 'Working on feature X',
        ];
    }

    /**
     * test_employee_can_submit_worklog_under_auto_flow
     */
    public function test_employee_can_submit_worklog_under_auto_flow(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $response->assertStatus(201);
        $this->assertDatabaseHas('attendance_worklogs', [
            'attendance_day_id' => $day->id,
            'worklog_status' => WorklogStatus::AUTO_APPROVED->value,
            'worklog_policy_version_id' => $wlPolicyVersion->id,
        ]);
    }

    /**
     * test_worklog_policy_version_stamped_at_submission
     */
    public function test_worklog_policy_version_stamped_at_submission(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        // Update policy creating version 2
        $wlPolicyVersion2 = $wlPolicyVersion->replicate();
        $wlPolicyVersion2->version = 2;
        $wlPolicyVersion2->created_at = now();
        $wlPolicyVersion2->save();

        $this->assertDatabaseHas('attendance_worklogs', [
            'attendance_day_id' => $day->id,
            'worklog_policy_version_id' => $wlPolicyVersion->id,
        ]);
    }

    /**
     * test_auto_flow_updates_attendance_day_compliance_to_compliant
     */
    public function test_auto_flow_updates_attendance_day_compliance_to_compliant(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $day->refresh();
        $this->assertEquals(AttendanceComplianceStatusEnum::COMPLIANT, $day->compliance_status);
    }

    /**
     * test_employee_can_submit_worklog_under_single_approval_flow
     */
    public function test_employee_can_submit_worklog_under_single_approval_flow(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::SINGLE_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $response->assertStatus(201);
        $this->assertDatabaseHas('attendance_worklogs', [
            'attendance_day_id' => $day->id,
            'worklog_status' => WorklogStatus::SUBMITTED->value,
        ]);
    }

    /**
     * test_manager_can_approve_worklog_single_approval
     */
    public function test_manager_can_approve_worklog_single_approval(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::SINGLE_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        $manager = $this->createUserWithOrg($organization);

        $approveResponse = $this->actingAsTenant($manager, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve", ['remarks' => 'Good job']);

        $approveResponse->assertStatus(200);
        $this->assertDatabaseHas('attendance_worklogs', [
            'uuid' => $worklogUuid,
            'worklog_status' => WorklogStatus::APPROVED->value,
            'approved_by' => $manager->id,
        ]);
    }

    /**
     * test_manager_can_reject_worklog
     */
    public function test_manager_can_reject_worklog(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::SINGLE_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        $manager = $this->createUserWithOrg($organization);

        $rejectResponse = $this->actingAsTenant($manager, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/reject", ['rejection_reason' => 'Invalid']);

        $rejectResponse->assertStatus(200);
        $this->assertDatabaseHas('attendance_worklogs', [
            'uuid' => $worklogUuid,
            'worklog_status' => WorklogStatus::REJECTED->value,
            'rejected_by' => $manager->id,
        ]);
    }

    /**
     * test_multi_level_first_approval_keeps_status_submitted
     */
    public function test_multi_level_first_approval_keeps_status_submitted(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::MULTI_LEVEL_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        $manager = $this->createUserWithOrg($organization);

        $this->actingAsTenant($manager, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve");

        $this->assertDatabaseHas('attendance_worklogs', [
            'uuid' => $worklogUuid,
            'worklog_status' => WorklogStatus::SUBMITTED->value,
            'approved_by' => $manager->id,
            'second_approver_id' => null,
        ]);
    }

    /**
     * test_multi_level_second_approval_finalizes_worklog
     */
    public function test_multi_level_second_approval_finalizes_worklog(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::MULTI_LEVEL_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        $manager1 = $this->createUserWithOrg($organization);
        $manager2 = $this->createUserWithOrg($organization);

        $r1 = $this->actingAsTenant($manager1, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve");
        $r1->dump();

        $r2 = $this->actingAsTenant($manager2, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve");
        $r2->dump();

        $this->assertDatabaseHas('attendance_worklogs', [
            'uuid' => $worklogUuid,
            'worklog_status' => WorklogStatus::APPROVED->value,
            'approved_by' => $manager1->id,
            'second_approver_id' => $manager2->id,
        ]);
    }

    /**
     * test_employee_cannot_approve_own_worklog
     */
    public function test_employee_cannot_approve_own_worklog(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::SINGLE_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        $approveResponse = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve");

        $approveResponse->assertStatus(403);
    }

    /**
     * test_overflow_justification_required_when_policy_enforces_it
     */
    public function test_overflow_justification_required_when_policy_enforces_it(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $wlPolicy->require_justification_on_overflow = true;
        $wlPolicy->save();

        $payload = array_merge($this->getValidWorklogPayload(90), [
            'attendance_session_uuid' => $session->uuid,
        ]);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $payload);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'WORKLOG_OVERFLOW_JUSTIFICATION_REQUIRED');
    }

    /**
     * test_overflow_allowed_with_justification
     */
    public function test_overflow_allowed_with_justification(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $wlPolicy->require_justification_on_overflow = true;
        $wlPolicy->save();

        $payload = array_merge($this->getValidWorklogPayload(90), [
            'attendance_session_uuid' => $session->uuid,
            'justification' => 'Forgot to clock in',
        ]);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $payload);

        $response->assertStatus(201);
    }

    /**
     * test_multiple_worklogs_per_session_blocked_when_policy_disallows
     */
    public function test_multiple_worklogs_per_session_blocked_when_policy_disallows(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $wlPolicy->allow_multiple_worklogs_per_session = false;
        $wlPolicy->save();

        $payload = array_merge($this->getValidWorklogPayload(30), [
            'attendance_session_uuid' => $session->uuid,
        ]);

        $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $payload)
            ->assertStatus(201);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $payload);

        $response->assertStatus(409)
            ->assertJsonPath('error_code', 'WORKLOG_ALREADY_EXISTS_FOR_SESSION');
    }

    /**
     * test_submission_window_closed_after_lock_after_days
     */
    public function test_submission_window_closed_after_lock_after_days(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $day->attendance_date = now()->subDays(10)->toDateString();
        $day->save();

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'WORKLOG_LOCKED');
    }

    /**
     * test_description_required_when_policy_enforces_it
     */
    public function test_description_required_when_policy_enforces_it(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $wlPolicy->require_description = true;
        $wlPolicy->min_description_length = 10;
        $wlPolicy->save();

        $payload = $this->getValidWorklogPayload();
        $payload['description'] = 'Short';

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $payload);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'WORKLOG_DESCRIPTION_REQUIRED');
    }

    /**
     * test_approval_uses_snapshot_not_live_policy
     */
    public function test_approval_uses_snapshot_not_live_policy(): void
    {
        $this->withoutExceptionHandling();
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::SINGLE_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        // Update live policy to MultiLevel
        $wlPolicyVersion2 = $wlPolicyVersion->replicate();
        $wlPolicyVersion2->version = 2;
        $wlPolicyVersion2->approval_flow = ApprovalFlow::MULTI_LEVEL_APPROVAL->value;
        $wlPolicyVersion2->created_at = now();
        $wlPolicyVersion2->save();
        $wlPolicy->approval_flow = ApprovalFlow::MULTI_LEVEL_APPROVAL;
        $wlPolicy->save();

        $manager = $this->createUserWithOrg($organization);

        // Even though live policy is MultiLevel, the snapshot was SingleApproval
        $this->actingAsTenant($manager, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve")
            ->assertStatus(200);

        $this->assertDatabaseHas('attendance_worklogs', [
            'uuid' => $worklogUuid,
            'worklog_status' => WorklogStatus::APPROVED->value,
            'second_approver_id' => null,
        ]);
    }

    /**
     * test_worklog_for_day_endpoint_returns_correct_worklogs
     */
    public function test_worklog_for_day_endpoint_returns_correct_worklogs(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->getJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs");

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    /**
     * test_organization_isolation_on_worklogs
     */
    public function test_organization_isolation_on_worklogs(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup();

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');

        $org2 = Organization::create([
            'legal_name' => 'Test Org 2',
            'slug' => 'test-org-2-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value ?? 'organization',
            'is_active' => true,
        ]);
        $user2 = $this->createUserWithOrg($org2);

        $this->actingAsTenant($user2, $org2)
            ->withHeader('X-Organization-Uuid', $org2->uuid)
            ->getJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}")
            ->assertStatus(404);
    }

    /**
     * test_status_history_recorded_on_submit_and_approve
     */
    public function test_status_history_recorded_on_submit_and_approve(): void
    {
        [$organization, $user, $day, $session, $wlPolicy, $wlPolicyVersion] = $this->createOrgWithWorklogSetup(ApprovalFlow::SINGLE_APPROVAL);

        $response = $this->actingAsTenant($user, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", $this->getValidWorklogPayload());

        $worklogUuid = $response->json('data.uuid');
        $worklogId = AttendanceWorklog::where('uuid', $worklogUuid)->first()->id;

        $this->assertDatabaseCount('worklog_status_histories', 1);

        $manager = $this->createUserWithOrg($organization);

        $this->actingAsTenant($manager, $organization)
            ->withHeader('X-Organization-Uuid', $organization->uuid)
            ->postJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}/approve");

        $this->assertDatabaseHas('worklog_status_histories', [
            'attendance_worklog_id' => $worklogId,
            'new_status' => WorklogStatus::APPROVED->value,
        ]);
        $this->assertDatabaseCount('worklog_status_histories', 2);
    }
}
