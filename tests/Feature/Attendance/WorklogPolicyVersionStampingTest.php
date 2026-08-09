<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WorklogPolicyVersionStampingTest extends TestCase
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

    public function test_update_via_real_endpoint_then_submit_stamps_nonnull_version(): void
    {
        $user = User::factory()->create();
        $org = Organization::create([
            'legal_name' => 'Test Org',
            'slug' => 'test-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($org->id);
        foreach (['WORKLOG_POLICY_VIEW', 'WORKLOG_POLICY_MANAGE', 'WORKLOG_CREATE', 'WORKLOG_VIEW'] as $perm) {
            $p = \App\Models\Rbac\Permission::where('name', \App\Enums\SystemPermission::{$perm}->value)->where('guard_name', 'api')->first();
            if ($p) {
                $user->givePermissionTo($p);
            }
        }
        setPermissionsTeamId(null);

        // Attendance policy is a precondition for worklog submission.
        $attPolicy = new AttendancePolicy();
        $attPolicy->organization_id = $org->id;
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
        $attPolicy->strict_worklog_enforcement = false;
        $attPolicy->created_by = $user->id;
        $attPolicy->updated_by = $user->id;
        $attPolicy->save();

        $attPolicyVersion = new AttendancePolicyVersion();
        $attPolicyVersion->attendance_policy_id = $attPolicy->id;
        $attPolicyVersion->version = 1;
        $attPolicyVersion->organization_id = $org->id;
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
        $attPolicyVersion->strict_worklog_enforcement = false;
        $attPolicyVersion->created_by = $user->id;
        $attPolicyVersion->created_at = now();
        $attPolicyVersion->save();

        $day = new AttendanceDay();
        $day->user_id = $user->id;
        $day->organization_id = $org->id;
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

        $this->actingAsTenant($user, $org);

        // 1. Update the worklog policy via the real endpoint (auto-provisions +
        // creates version 1 on first touch, then version 2 for this update).
        $updateResponse = $this->patchJson('/api/v1/organization/attendance/worklog-policy', [
            'submission_window_days' => 10,
        ]);
        $updateResponse->assertStatus(200);

        $versionCount = WorklogPolicyVersion::where('organization_id', $org->id)->count();
        echo "\n=== WORKLOG POLICY VERSION STAMPING ===\nVersions after update: {$versionCount}\n";
        $this->assertSame(2, $versionCount);

        // 2. Submit a worklog via the real endpoint.
        $submitResponse = $this->postJson("/api/v1/organization/attendance/days/{$day->uuid}/worklogs", [
            'logged_minutes' => 30,
            'description' => 'Testing version stamping end to end',
        ]);
        $submitResponse->assertStatus(201);

        $worklogUuid = $submitResponse->json('data.uuid');
        $stampedVersionId = \App\Models\Attendance\AttendanceWorklog::where('uuid', $worklogUuid)->value('worklog_policy_version_id');

        echo "worklog_policy_version_id: " . var_export($stampedVersionId, true) . "\n";

        $this->assertNotNull($stampedVersionId, 'worklog_policy_version_id should not be null after this fix.');

        $latestVersion = WorklogPolicyVersion::where('organization_id', $org->id)->orderBy('version', 'desc')->first();
        $this->assertSame($latestVersion->id, $stampedVersionId, 'Should stamp the latest (version 2) snapshot, reflecting the update.');
        $this->assertSame(10, $latestVersion->submission_window_days);
    }
}
