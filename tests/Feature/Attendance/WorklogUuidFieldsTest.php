<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Project\Milestone;
use App\Models\Project\Project;
use App\Models\Project\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WorklogUuidFieldsTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsTenant(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');
        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user, $org, \App\Enums\Guard::ORGANIZATION, 'Manager'
        );
        $this->withToken($token);
        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
        return $this;
    }

    protected function setup_org_day(): array
    {
        $user = User::factory()->create();
        $org = Organization::create([
            'legal_name' => 'Uuid Fields Org', 'slug' => 'uuid-fields-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value, 'is_active' => true,
        ]);
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($org->id);
        foreach (['WORKLOG_CREATE', 'WORKLOG_VIEW'] as $perm) {
            $p = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::{$perm}->value)->where('guard_name', 'api')->first();
            if ($p) $user->givePermissionTo($p);
        }
        setPermissionsTeamId(null);

        $attPolicy = AttendancePolicy::create([
            'organization_id' => $org->id, 'attendance_mode' => 2, 'approval_flow' => 1,
            'shift_start_time' => '09:00:00', 'shift_end_time' => '17:00:00',
            'required_daily_minutes' => 480, 'minimum_session_minutes' => 60, 'grace_late_minutes' => 15,
            'allowed_monthly_late_count' => 3, 'allow_early_exit' => false, 'default_break_minutes' => 60,
            'max_break_minutes' => 60, 'allow_multiple_sessions' => true, 'allow_clock_in_on_holidays' => false,
            'auto_clock_out_enabled' => false, 'overtime_enabled' => false, 'weekend_days' => [6, 7],
            'geo_fencing_enabled' => false, 'ip_restriction_enabled' => false, 'strict_worklog_enforcement' => false,
            'created_by' => $user->id, 'updated_by' => $user->id,
        ]);
        $attPolicyVersion = AttendancePolicyVersion::create([
            'attendance_policy_id' => $attPolicy->id, 'version' => 1, 'organization_id' => $org->id,
            'attendance_mode' => 1, 'approval_flow' => \App\Enums\Attendance\ApprovalFlow::AUTO,
            'shift_start_time' => '09:00:00', 'shift_end_time' => '17:00:00', 'required_daily_minutes' => 480,
            'minimum_session_minutes' => 60, 'grace_late_minutes' => 15, 'allowed_monthly_late_count' => 3,
            'allow_early_exit' => false, 'default_break_minutes' => 60, 'max_break_minutes' => 60,
            'allow_multiple_sessions' => true, 'allow_clock_in_on_holidays' => false, 'auto_clock_out_enabled' => false,
            'overtime_enabled' => false, 'weekend_days' => [6, 7], 'geo_fencing_enabled' => false,
            'ip_restriction_enabled' => false, 'strict_worklog_enforcement' => false,
            'created_by' => $user->id, 'created_at' => now(),
        ]);
        $day = AttendanceDay::create([
            'user_id' => $user->id, 'organization_id' => $org->id, 'attendance_date' => now()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::PRESENT,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::PENDING,
            'attendance_policy_version_id' => $attPolicyVersion->id,
        ]);

        return [$user, $org, $day];
    }

    public function test_submit_with_project_uuid_succeeds(): void
    {
        [$user, $org, $day] = $this->setup_org_day();
        $project = Project::create([
            'organization_id' => $org->id, 'name' => 'Test Project', 'uuid' => (string) Str::uuid(), 'is_active' => true,
        ]);
        $project->users()->attach($user->id);

        $response = $this->actingAsTenant($user, $org)->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", [
            'logged_minutes' => 30,
            'description' => 'Working via uuid field',
            'project_uuid' => $project->uuid,
        ]);

        echo "\n=== SUBMIT WITH project_uuid ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(201);
        $this->assertDatabaseHas('attendance_worklogs', ['uuid' => $response->json('data.uuid'), 'project_id' => $project->id]);
    }

    public function test_submit_with_old_raw_project_id_now_returns_422(): void
    {
        [$user, $org, $day] = $this->setup_org_day();
        $project = Project::create([
            'organization_id' => $org->id, 'name' => 'Test Project 2', 'uuid' => (string) Str::uuid(), 'is_active' => true,
        ]);

        $response = $this->actingAsTenant($user, $org)->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", [
            'logged_minutes' => 30,
            'description' => 'Sending legacy project_id field',
            'project_id' => $project->id,
        ]);

        echo "\n=== SUBMIT WITH legacy project_id (now prohibited) ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        // project_id is now explicitly prohibited -- a clear 422 telling the
        // client to use project_uuid, instead of silently dropping the field
        // and creating a worklog with a missing association.
        $response->assertStatus(422);
        $response->assertJsonPath('errors.project_id.0', 'project_id is deprecated; use project_uuid instead.');
        $this->assertDatabaseMissing('attendance_worklogs', ['description' => 'Sending legacy project_id field']);
    }

    public function test_submit_with_project_uuid_unaffected_by_prohibited_rule(): void
    {
        [$user, $org, $day] = $this->setup_org_day();
        $project = Project::create([
            'organization_id' => $org->id, 'name' => 'Test Project 3', 'uuid' => (string) Str::uuid(), 'is_active' => true,
        ]);
        $project->users()->attach($user->id);

        $response = $this->actingAsTenant($user, $org)->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", [
            'logged_minutes' => 30,
            'description' => 'Still works via project_uuid',
            'project_uuid' => $project->uuid,
        ]);

        echo "\n=== SUBMIT WITH project_uuid (should be unaffected) ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(201);
        $this->assertDatabaseHas('attendance_worklogs', ['uuid' => $response->json('data.uuid'), 'project_id' => $project->id]);
    }
}
