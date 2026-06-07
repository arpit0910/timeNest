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
        $policy = $this->policyService->getActivePolicy($organization);
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
            'attendance_policy_id' => $policy->id,
        ], [
            'require_worklog_on_clockout' => false,
            'allow_deferred_submission' => true,
            'require_project_mapping' => false,
            'require_task_mapping' => false,
            'require_justification_on_overflow' => true,
            'auto_escalate_overdue_logs' => false,
            'overdue_after_days' => 1,
            'lock_after_days' => 3,
            'allow_multiple_worklogs_per_session' => true,
            'strict_mode_enabled' => false,
            'flexible_mode_enabled' => true,
            'hybrid_mode_enabled' => false,
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
