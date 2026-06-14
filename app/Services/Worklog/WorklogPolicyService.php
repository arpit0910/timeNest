<?php

declare(strict_types=1);

namespace App\Services\Worklog;

use App\Exceptions\Worklog\WorklogPolicyAlreadyExistsException;
use App\Exceptions\Worklog\WorklogPolicyNotFoundException;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Worklog\WorklogPolicy;
use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorklogPolicyService
{
    /**
     * Create a new worklog policy for the given organization.
     *
     * @param Organization $organization
     * @param array $data
     * @param User $createdBy
     * @return WorklogPolicy
     */
    public function createPolicy(Organization $organization, array $data, User $createdBy): WorklogPolicy
    {
        if (WorklogPolicy::where('organization_id', $organization->id)->exists()) {
            throw new WorklogPolicyAlreadyExistsException();
        }

        return DB::transaction(function () use ($organization, $data, $createdBy) {
            $data['organization_id'] = $organization->id;
            $data['created_by'] = $createdBy->id;
            $data['updated_by'] = $createdBy->id;

            $policy = WorklogPolicy::create($data);
            $policy->refresh();

            $this->createVersionSnapshot($policy, 1, $createdBy);

            return $policy->load('versions');
        });
    }

    /**
     * Update an existing worklog policy.
     *
     * @param WorklogPolicy $policy
     * @param array $data
     * @param User $updatedBy
     * @return WorklogPolicy
     */
    public function updatePolicy(WorklogPolicy $policy, array $data, User $updatedBy): WorklogPolicy
    {
        return DB::transaction(function () use ($policy, $data, $updatedBy) {
            $maxVersion = WorklogPolicyVersion::where('worklog_policy_id', $policy->id)
                ->lockForUpdate()
                ->max('version');

            $nextVersion = $maxVersion ? ((int) $maxVersion) + 1 : 1;

            $data['updated_by'] = $updatedBy->id;
            $policy->update($data);
            $policy->refresh();

            $this->createVersionSnapshot($policy, $nextVersion, $updatedBy);

            return $policy->fresh('versions');
        });
    }

    /**
     * Get the active policy for an organization.
     *
     * @param Organization $organization
     * @return WorklogPolicy
     */
    public function getPolicy(Organization $organization): WorklogPolicy
    {
        $policy = WorklogPolicy::where('organization_id', $organization->id)
            ->with('versions')
            ->first();

        if (!$policy) {
            throw new WorklogPolicyNotFoundException();
        }

        return $policy;
    }

    /**
     * Get a policy by its UUID for a given organization.
     *
     * @param string $uuid
     * @param Organization $organization
     * @return WorklogPolicy
     */
    public function getPolicyByUuid(string $uuid, Organization $organization): WorklogPolicy
    {
        $policy = WorklogPolicy::where('uuid', $uuid)
            ->where('organization_id', $organization->id)
            ->with('versions')
            ->first();

        if (!$policy) {
            throw new WorklogPolicyNotFoundException();
        }

        return $policy;
    }

    /**
     * Get all versions of a policy, ordered by version descending.
     *
     * @param WorklogPolicy $policy
     * @return Collection
     */
    public function getPolicyVersions(WorklogPolicy $policy): Collection
    {
        return WorklogPolicyVersion::where('worklog_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->get();
    }

    /**
     * Resolve the latest current version for a policy.
     *
     * @param WorklogPolicy $policy
     * @return WorklogPolicyVersion
     */
    public function resolveCurrentVersion(WorklogPolicy $policy): WorklogPolicyVersion
    {
        $version = WorklogPolicyVersion::where('worklog_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->first();

        if (!$version) {
            throw new WorklogPolicyNotFoundException('No version snapshot exists for this policy.');
        }

        return $version;
    }

    /**
     * Create an immutable snapshot version of the provided policy state.
     *
     * @param WorklogPolicy $policy
     * @param int $version
     * @param User $createdBy
     * @return WorklogPolicyVersion
     */
    private function createVersionSnapshot(WorklogPolicy $policy, int $version, User $createdBy): WorklogPolicyVersion
    {
        return WorklogPolicyVersion::create([
            'worklog_policy_id' => $policy->id,
            'version' => $version,
            'organization_id' => $policy->organization_id,
            'worklog_mode' => $policy->worklog_mode->value,
            'approval_flow' => $policy->approval_flow->value,
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
