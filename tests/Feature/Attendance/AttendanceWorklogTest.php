<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Actions\IssueJwtAction;
use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Enums\WorkflowStatusEnum;
use App\Enums\WorklogComplianceStatusEnum;
use App\Enums\EscalationTypeEnum;
use App\Enums\EscalationStatusEnum;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Attendance\WorklogPolicy;
use App\Models\Auth\User;
use App\Models\Organization\Branch;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Project\Project;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Models\Rbac\Role;
use App\Models\Rbac\Permission;
use App\Services\Attendance\AttendancePolicyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class AttendanceWorklogTest extends TestCase
{
    use RefreshDatabase;

    private User $employeeUser;
    private User $managerUser;
    private Organization $organization;
    private string $employeeToken;
    private string $managerToken;
    private AttendancePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create organization
        $this->organization = Organization::create([
            'legal_name' => 'Tech Organization',
            'slug' => 'tech-organization',
            'is_active' => true,
            'is_verified' => true,
        ]);

        // 2. Create Roles & Permissions
        $employeeRole = Role::create([
            'name' => SystemRole::Employee->value,
            'guard_name' => 'api',
            'is_system_role' => true,
        ]);

        $managerRole = Role::create([
            'name' => SystemRole::Manager->value,
            'guard_name' => 'api',
            'is_system_role' => true,
        ]);

        $statusUpdatePerm = Permission::create([
            'name' => 'attendance_worklogs_update_status',
            'guard_name' => 'api',
        ]);

        $escalationResolvePerm = Permission::create([
            'name' => 'attendance_escalations_resolve',
            'guard_name' => 'api',
        ]);

        $managerRole->givePermissionTo($statusUpdatePerm);
        $managerRole->givePermissionTo($escalationResolvePerm);

        // 3. Create Users
        $this->employeeUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
            'timezone' => 'Asia/Kolkata',
        ]);

        $this->managerUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
            'timezone' => 'Asia/Kolkata',
        ]);

        // 4. Create Memberships
        $empMem = OrganizationMembership::create([
            'user_id' => $this->employeeUser->id,
            'organization_id' => $this->organization->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);

        $mgrMem = OrganizationMembership::create([
            'user_id' => $this->managerUser->id,
            'organization_id' => $this->organization->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($this->organization->id);
        $this->employeeUser->assignRole($employeeRole);
        $this->managerUser->assignRole($managerRole);
        setPermissionsTeamId(null);

        // 5. Create Branch
        $branch = Branch::create([
            'organization_id' => $this->organization->id,
            'name' => 'HQ branch',
            'code' => 'HQ001',
            'latitude' => 12.9716,
            'longitude' => 77.5946,
            'geo_fence_radius' => 200,
            'timezone' => 'Asia/Kolkata',
            'is_active' => true,
        ]);

        // 6. Create Employee Profiles
        EmployeeProfile::create([
            'user_id' => $this->employeeUser->id,
            'organization_id' => $this->organization->id,
            'organization_membership_id' => $empMem->id,
            'employee_code' => 'EMP001',
            'branch_id' => $branch->id,
            'is_active' => true,
        ]);

        EmployeeProfile::create([
            'user_id' => $this->managerUser->id,
            'organization_id' => $this->organization->id,
            'organization_membership_id' => $mgrMem->id,
            'employee_code' => 'MGR001',
            'branch_id' => $branch->id,
            'is_active' => true,
        ]);

        // 7. Create Default Policy
        $policyService = app(AttendancePolicyService::class);
        $this->policy = $policyService->createDefaultPolicy($this->organization, $this->managerUser);

        // 8. Issue JWT Tokens
        $issueJwtAction = app(IssueJwtAction::class);
        $this->employeeToken = $issueJwtAction->issueAccessToken(
            $this->employeeUser,
            $this->organization,
            \App\Enums\Guard::Organization,
            SystemRole::Employee->value
        );

        $this->managerToken = $issueJwtAction->issueAccessToken(
            $this->managerUser,
            $this->organization,
            \App\Enums\Guard::Organization,
            SystemRole::Manager->value
        );
    }

    private function employeeHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->employeeToken}",
            'X-Organization-Uuid' => $this->organization->uuid,
        ];
    }

    private function managerHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->managerToken}",
            'X-Organization-Uuid' => $this->organization->uuid,
        ];
    }

    public function test_get_and_update_worklog_policy(): void
    {
        // 1. Get current worklog policy
        $response = $this->withHeaders($this->managerHeaders())
            ->getJson('/api/v1/organization/attendance/worklog-policy');

        $response->assertStatus(200)
            ->assertJsonPath('data.allow_deferred_submission', true);

        // 2. Update worklog policy
        $response = $this->withHeaders($this->managerHeaders())
            ->patchJson('/api/v1/organization/attendance/worklog-policy', [
                'strict_mode_enabled' => true,
                'require_project_mapping' => true,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.strict_mode_enabled', true)
            ->assertJsonPath('data.require_project_mapping', true);
    }

    public function test_create_and_update_worklog_with_valid_hierarchy(): void
    {
        // Create Mock Project, Milestone, Task
        $project = Project::create([
            'organization_id' => $this->organization->id,
            'name' => 'Project Alpha',
            'is_active' => true,
        ]);
        $project->users()->attach($this->employeeUser->id);

        $milestone = Milestone::create([
            'project_id' => $project->id,
            'name' => 'Milestone 1',
        ]);

        $task = Task::create([
            'milestone_id' => $milestone->id,
            'name' => 'Coding Task',
            'estimated_minutes' => 120,
        ]);

        // Create Attendance Day
        $day = AttendanceDay::create([
            'user_id' => $this->employeeUser->id,
            'organization_id' => $this->organization->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::Present->value,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::Compliant->value,
        ]);

        // Create Attendance Session
        $session = new AttendanceSession();
        $session->attendance_day_id = $day->id;
        $session->clock_in_at = Carbon::now()->subHours(2);
        $session->clock_out_at = Carbon::now();
        $session->clock_in_source = \App\Enums\AttendanceSessionSourceEnum::Web;
        $session->clock_out_source = \App\Enums\AttendanceSessionSourceEnum::Web;
        $session->save();

        // Store Worklog
        $response = $this->withHeaders($this->employeeHeaders())
            ->postJson('/api/v1/organization/attendance/worklogs', [
                'attendance_day_uuid' => $day->uuid,
                'attendance_session_uuid' => $session->uuid,
                'project_uuid' => $project->uuid,
                'milestone_uuid' => $milestone->uuid,
                'task_uuid' => $task->uuid,
                'logged_minutes' => 60,
                'description' => 'Working on task coding',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.logged_minutes', 60);

        $worklogUuid = $response->json('data.uuid');

        // Update Worklog
        $response = $this->withHeaders($this->employeeHeaders())
            ->patchJson("/api/v1/organization/attendance/worklogs/{$worklogUuid}", [
                'logged_minutes' => 90,
                'description' => 'Updated task coding time',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.logged_minutes', 90);
    }

    public function test_worklog_task_overflow_compliance(): void
    {
        $project = Project::create([
            'organization_id' => $this->organization->id,
            'name' => 'Project Alpha',
            'is_active' => true,
        ]);
        $project->users()->attach($this->employeeUser->id);

        $milestone = Milestone::create([
            'project_id' => $project->id,
            'name' => 'Milestone 1',
        ]);

        $task = Task::create([
            'milestone_id' => $milestone->id,
            'name' => 'Coding Task',
            'estimated_minutes' => 60, // Estimated only 60 minutes
        ]);

        $day = AttendanceDay::create([
            'user_id' => $this->employeeUser->id,
            'organization_id' => $this->organization->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::Present->value,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::Compliant->value,
        ]);

        // Attempting to log 120 minutes without justification (Overflow should fail if required)
        $response = $this->withHeaders($this->employeeHeaders())
            ->postJson('/api/v1/organization/attendance/worklogs', [
                'attendance_day_uuid' => $day->uuid,
                'project_uuid' => $project->uuid,
                'milestone_uuid' => $milestone->uuid,
                'task_uuid' => $task->uuid,
                'logged_minutes' => 120, // Over estimated 60 minutes
                'description' => 'Exceeding estimates',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['justification']);

        // Correctly log with justification
        $response = $this->withHeaders($this->employeeHeaders())
            ->postJson('/api/v1/organization/attendance/worklogs', [
                'attendance_day_uuid' => $day->uuid,
                'project_uuid' => $project->uuid,
                'milestone_uuid' => $milestone->uuid,
                'task_uuid' => $task->uuid,
                'logged_minutes' => 120,
                'justification' => 'Task took longer due to API bugs.',
                'description' => 'Exceeding estimates with reason',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.compliance_status.value', WorklogComplianceStatusEnum::Overflow->value);
    }

    public function test_workflow_state_transitions_and_permissions(): void
    {
        $project = Project::create([
            'organization_id' => $this->organization->id,
            'name' => 'Project Alpha',
            'is_active' => true,
        ]);
        $project->users()->attach($this->employeeUser->id);

        $day = AttendanceDay::create([
            'user_id' => $this->employeeUser->id,
            'organization_id' => $this->organization->id,
            'attendance_date' => Carbon::today()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::Present->value,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::Compliant->value,
        ]);

        // 1. Employee creates a draft worklog
        $response = $this->withHeaders($this->employeeHeaders())
            ->postJson('/api/v1/organization/attendance/worklogs', [
                'attendance_day_uuid' => $day->uuid,
                'project_uuid' => $project->uuid,
                'logged_minutes' => 60,
                'description' => 'Draft worklog',
            ]);

        $response->assertStatus(201);
        $uuid = $response->json('data.uuid');

        // 2. Employee submits the worklog
        $response = $this->withHeaders($this->employeeHeaders())
            ->patchJson("/api/v1/organization/attendance/worklogs/{$uuid}/status", [
                'status' => WorkflowStatusEnum::Submitted->value,
                'remarks' => 'Submitting my draft worklog',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.worklog_status.value', WorkflowStatusEnum::Submitted->value);

        // 3. Employee attempts to approve the worklog (should fail - no permission)
        $response = $this->withHeaders($this->employeeHeaders())
            ->patchJson("/api/v1/organization/attendance/worklogs/{$uuid}/status", [
                'status' => WorkflowStatusEnum::Approved->value,
            ]);

        $response->assertStatus(403);

        // 4. Manager approves the worklog
        $response = $this->withHeaders($this->managerHeaders())
            ->patchJson("/api/v1/organization/attendance/worklogs/{$uuid}/status", [
                'status' => WorkflowStatusEnum::Approved->value,
                'remarks' => 'Looks good, approved.',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.worklog_status.value', WorkflowStatusEnum::Approved->value);
    }
}
