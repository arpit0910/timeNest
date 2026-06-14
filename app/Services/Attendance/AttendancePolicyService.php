<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Exceptions\Attendance\AttendancePolicyAlreadyExistsException;
use App\Exceptions\Attendance\AttendancePolicyNotFoundException;
use App\Exceptions\Attendance\InvalidPenaltySlabException;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttendancePolicyService
{
    /**
     * Create a new attendance policy for the given organization.
     *
     * @param Organization $organization
     * @param array $data
     * @param User $createdBy
     * @return AttendancePolicy
     */
    public function createPolicy(Organization $organization, array $data, User $createdBy): AttendancePolicy
    {
        if (AttendancePolicy::where('organization_id', $organization->id)->exists()) {
            throw new AttendancePolicyAlreadyExistsException();
        }

        $this->validatePenaltySlabs($data);

        return DB::transaction(function () use ($organization, $data, $createdBy) {
            $data['organization_id'] = $organization->id;
            $data['created_by'] = $createdBy->id;
            $data['updated_by'] = $createdBy->id;

            $createData = \Illuminate\Support\Arr::except($data, ['late_penalty_slabs', 'work_duration_penalty_slabs']);
            $policy = AttendancePolicy::create($createData);
            $policy->refresh();

            $this->createVersionSnapshot($policy, 1, $createdBy);

            if (!empty($data['late_penalty_slabs'])) {
                foreach ($data['late_penalty_slabs'] as $slabData) {
                    $policy->latePenaltySlabs()->create($slabData);
                }
            }

            if (!empty($data['work_duration_penalty_slabs'])) {
                foreach ($data['work_duration_penalty_slabs'] as $slabData) {
                    $policy->workDurationPenaltySlabs()->create($slabData);
                }
            }

            return $policy->load(['versions', 'latePenaltySlabs', 'workDurationPenaltySlabs']);
        });
    }

    /**
     * Update an existing attendance policy.
     *
     * @param AttendancePolicy $policy
     * @param array $data
     * @param User $updatedBy
     * @return AttendancePolicy
     */
    public function updatePolicy(AttendancePolicy $policy, array $data, User $updatedBy): AttendancePolicy
    {
        $this->validatePenaltySlabs($data);

        return DB::transaction(function () use ($policy, $data, $updatedBy) {
            $maxVersion = AttendancePolicyVersion::where('attendance_policy_id', $policy->id)
                ->lockForUpdate()
                ->max('version');

            $nextVersion = $maxVersion ? ((int) $maxVersion) + 1 : 1;

            $data['updated_by'] = $updatedBy->id;
            $updateData = \Illuminate\Support\Arr::except($data, ['late_penalty_slabs', 'work_duration_penalty_slabs']);
            $policy->update($updateData);
            $policy->refresh();

            $this->createVersionSnapshot($policy, $nextVersion, $updatedBy);

            if (isset($data['late_penalty_slabs'])) {
                $policy->latePenaltySlabs()->delete();
                foreach ($data['late_penalty_slabs'] as $slabData) {
                    $policy->latePenaltySlabs()->create($slabData);
                }
            }

            if (isset($data['work_duration_penalty_slabs'])) {
                $policy->workDurationPenaltySlabs()->delete();
                foreach ($data['work_duration_penalty_slabs'] as $slabData) {
                    $policy->workDurationPenaltySlabs()->create($slabData);
                }
            }

            return $policy->fresh(['versions', 'latePenaltySlabs', 'workDurationPenaltySlabs']);
        });
    }

    /**
     * Get the active policy for an organization.
     *
     * @param Organization $organization
     * @return AttendancePolicy
     */
    public function getPolicy(Organization $organization): AttendancePolicy
    {
        $policy = AttendancePolicy::where('organization_id', $organization->id)
            ->with(['versions', 'latePenaltySlabs', 'workDurationPenaltySlabs'])
            ->first();

        if (!$policy) {
            throw new AttendancePolicyNotFoundException();
        }

        return $policy;
    }

    /**
     * Get a policy by its UUID for a given organization.
     *
     * @param string $uuid
     * @param Organization $organization
     * @return AttendancePolicy
     */
    public function getPolicyByUuid(string $uuid, Organization $organization): AttendancePolicy
    {
        $policy = AttendancePolicy::where('uuid', $uuid)
            ->where('organization_id', $organization->id)
            ->with(['versions', 'latePenaltySlabs', 'workDurationPenaltySlabs'])
            ->first();

        if (!$policy) {
            throw new AttendancePolicyNotFoundException();
        }

        return $policy;
    }

    /**
     * Get all versions of a policy, ordered by version descending.
     *
     * @param AttendancePolicy $policy
     * @return Collection
     */
    public function getPolicyVersions(AttendancePolicy $policy): Collection
    {
        return AttendancePolicyVersion::where('attendance_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->get();
    }

    /**
     * Resolve the latest current version for a policy.
     *
     * @param AttendancePolicy $policy
     * @return AttendancePolicyVersion
     */
    public function resolveCurrentVersion(AttendancePolicy $policy): AttendancePolicyVersion
    {
        $version = AttendancePolicyVersion::where('attendance_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->first();

        if (!$version) {
            throw new AttendancePolicyNotFoundException('No version snapshot exists for this policy.');
        }

        return $version;
    }

    /**
     * Validate the provided penalty slabs for uniqueness and overlaps.
     *
     * @param array $data
     * @return void
     */
    private function validatePenaltySlabs(array $data): void
    {
        if (!empty($data['late_penalty_slabs'])) {
            $thresholds = array_column($data['late_penalty_slabs'], 'late_count_threshold');
            if (count($thresholds) !== count(array_unique($thresholds))) {
                throw new InvalidPenaltySlabException('Duplicate late count thresholds are not allowed.');
            }
        }

        if (!empty($data['work_duration_penalty_slabs'])) {
            $slabs = $data['work_duration_penalty_slabs'];
            foreach ($slabs as $i => $slabA) {
                foreach ($slabs as $j => $slabB) {
                    if ($i !== $j) {
                        $minA = $slabA['min_work_minutes'];
                        $maxA = $slabA['max_work_minutes'];
                        $minB = $slabB['min_work_minutes'];
                        $maxB = $slabB['max_work_minutes'];

                        if (max($minA, $minB) <= min($maxA, $maxB)) {
                            throw new InvalidPenaltySlabException("Work duration penalty slabs must not overlap (Overlap between $minA-$maxA and $minB-$maxB).");
                        }
                    }
                }
            }
        }
    }

    /**
     * Create an immutable snapshot version of the provided policy state.
     *
     * @param AttendancePolicy $policy
     * @param int $version
     * @param User $createdBy
     * @return AttendancePolicyVersion
     */
    private function createVersionSnapshot(AttendancePolicy $policy, int $version, User $createdBy): AttendancePolicyVersion
    {
        return AttendancePolicyVersion::create([
            'attendance_policy_id' => $policy->id,
            'version' => $version,
            'organization_id' => $policy->organization_id,
            'attendance_mode' => $policy->attendance_mode->value,
            'approval_flow' => $policy->approval_flow->value,
            'shift_start_time' => $policy->shift_start_time,
            'shift_end_time' => $policy->shift_end_time,
            'required_daily_minutes' => $policy->required_daily_minutes,
            'minimum_session_minutes' => $policy->minimum_session_minutes,
            'grace_late_minutes' => $policy->grace_late_minutes,
            'allowed_monthly_late_count' => $policy->allowed_monthly_late_count,
            'allow_early_exit' => $policy->allow_early_exit,
            'grace_early_exit_minutes' => $policy->grace_early_exit_minutes,
            'default_break_minutes' => $policy->default_break_minutes,
            'max_break_minutes' => $policy->max_break_minutes,
            'allow_multiple_sessions' => $policy->allow_multiple_sessions,
            'allow_clock_in_on_holidays' => $policy->allow_clock_in_on_holidays,
            'auto_clock_out_enabled' => $policy->auto_clock_out_enabled,
            'auto_clock_out_after_minutes' => $policy->auto_clock_out_after_minutes,
            'overtime_enabled' => $policy->overtime_enabled,
            'overtime_starts_after_minutes' => $policy->overtime_starts_after_minutes,
            'max_daily_overtime_minutes' => $policy->max_daily_overtime_minutes,
            'overtime_requires_approval' => $policy->overtime_requires_approval,
            'weekend_days' => $policy->weekend_days,
            'geo_fencing_enabled' => $policy->geo_fencing_enabled,
            'geo_fence_radius_meters' => $policy->geo_fence_radius_meters,
            'ip_restriction_enabled' => $policy->ip_restriction_enabled,
            'strict_worklog_enforcement' => $policy->strict_worklog_enforcement,
            'created_by' => $createdBy->id,
            'created_at' => now(),
        ]);
    }
}
