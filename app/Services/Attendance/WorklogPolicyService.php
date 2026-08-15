<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\WorklogPolicy;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorklogPolicyService
{
    public function __construct(
        private readonly AttendancePolicyService $policyService
    ) {}

    /**
     * Resolve the worklog policy for an organization.
     */
    public function getWorklogPolicyForOrganization(Organization $organization, User $createdBy): WorklogPolicy
    {
        $policy = $this->policyService->getPolicy($organization);
        if (! $policy) {
            throw new \RuntimeException('Active attendance policy not configured.');
        }

        return $this->getOrCreateWorklogPolicy($policy, $createdBy);
    }

    /**
     * Get or create a worklog policy for a given attendance policy.
     */
    public function getOrCreateWorklogPolicy(AttendancePolicy $policy, User $createdBy): WorklogPolicy
    {
        $worklogPolicy = WorklogPolicy::firstOrCreate([
            'organization_id' => $policy->organization_id,
        ], [
            'worklog_mode' => 2, // Flexible
            'approval_flow' => 1, // Auto
            'require_worklog_on_clockout' => false,
            'allow_deferred_submission' => true,
            'submission_window_days' => 3,
            'edit_grace_days' => 1,
            'lock_after_days' => 7,
            'require_description' => true,
            'min_description_length' => 0,
            'require_justification_on_overflow' => true,
            'require_project_mapping' => false,
            'require_task_mapping' => false,
            'allow_multiple_worklogs_per_session' => true,
            'auto_escalate_overdue_logs' => false,
            'billable_tracking_enabled' => false,
        ]);

        if ($worklogPolicy->wasRecentlyCreated) {
            $this->createVersionSnapshot($worklogPolicy, 1, $createdBy);
        }

        return $worklogPolicy;
    }

    /**
     * Update the worklog policy.
     */
    public function updateWorklogPolicy(AttendancePolicy $policy, array $data, User $updatedBy): WorklogPolicy
    {
        return DB::transaction(function () use ($policy, $data, $updatedBy) {
            $worklogPolicy = $this->getOrCreateWorklogPolicy($policy, $updatedBy);

            $maxVersion = WorklogPolicyVersion::where('worklog_policy_id', $worklogPolicy->id)
                ->lockForUpdate()
                ->max('version');
            $nextVersion = $maxVersion ? ((int) $maxVersion) + 1 : 1;

            $worklogPolicy->update($data);
            $worklogPolicy->refresh();

            $this->createVersionSnapshot($worklogPolicy, $nextVersion, $updatedBy);

            notify_organization($policy->organization_id, \App\Enums\NotificationTypeEnum::POLICY_UPDATED, [
                'title' => 'Worklog policy updated',
                'body' => 'The worklog policy changed. Check the logging window and approval rules.',
                'action_url' => '/worklogs/policy',
                'subject' => $worklogPolicy,
                'actor' => $updatedBy,
                'data' => ['policy' => 'worklog', 'version' => $nextVersion],
            ]);

            return $worklogPolicy->fresh();
        });
    }

    /**
     * Get all versions of a worklog policy, ordered by version descending.
     */
    public function getPolicyVersions(WorklogPolicy $policy): Collection
    {
        return WorklogPolicyVersion::where('worklog_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->get();
    }

    /**
     * Create an immutable snapshot version of the provided policy state.
     *
     * Note: App\Models\Attendance\WorklogPolicy does not cast worklog_mode/
     * approval_flow to enums (unlike App\Models\Worklog\WorklogPolicy) — both
     * models read/write the same `worklog_policies` table, so these are
     * written here as raw ints, matching what's actually in the DB row.
     */
    private function createVersionSnapshot(WorklogPolicy $policy, int $version, User $createdBy): WorklogPolicyVersion
    {
        return WorklogPolicyVersion::create([
            'worklog_policy_id' => $policy->id,
            'version' => $version,
            'organization_id' => $policy->organization_id,
            'worklog_mode' => $policy->worklog_mode,
            'approval_flow' => $policy->approval_flow,
            'require_worklog_on_clockout' => $policy->require_worklog_on_clockout,
            'allow_deferred_submission' => $policy->allow_deferred_submission,
            'submission_window_days' => $policy->submission_window_days,
            'edit_grace_days' => $policy->edit_grace_days,
            'lock_after_days' => $policy->lock_after_days,
            'require_description' => $policy->require_description,
            'min_description_length' => $policy->min_description_length,
            'require_justification_on_overflow' => $policy->require_justification_on_overflow,
            'require_project_mapping' => $policy->require_project_mapping,
            'require_task_mapping' => $policy->require_task_mapping,
            'allow_multiple_worklogs_per_session' => $policy->allow_multiple_worklogs_per_session,
            'auto_escalate_overdue_logs' => $policy->auto_escalate_overdue_logs,
            'billable_tracking_enabled' => $policy->billable_tracking_enabled,
            'created_by' => $createdBy->id,
            'created_at' => now(),
        ]);
    }
}
