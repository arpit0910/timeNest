<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\WorklogPolicy;
use App\Models\Organization\Organization;

class WorklogPolicyService
{
    public function __construct(
        private readonly AttendancePolicyService $policyService
    ) {}

    /**
     * Resolve the worklog policy for an organization.
     */
    public function getWorklogPolicyForOrganization(Organization $organization): WorklogPolicy
    {
        $policy = $this->policyService->getPolicy($organization);
        if (! $policy) {
            throw new \RuntimeException('Active attendance policy not configured.');
        }

        return $this->getOrCreateWorklogPolicy($policy);
    }

    /**
     * Get or create a worklog policy for a given attendance policy.
     */
    public function getOrCreateWorklogPolicy(AttendancePolicy $policy): WorklogPolicy
    {
        return WorklogPolicy::firstOrCreate([
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
    }

    /**
     * Update the worklog policy.
     */
    public function updateWorklogPolicy(AttendancePolicy $policy, array $data): WorklogPolicy
    {
        $worklogPolicy = $this->getOrCreateWorklogPolicy($policy);
        $worklogPolicy->update($data);
        return $worklogPolicy->fresh();
    }
}
