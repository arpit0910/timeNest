<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendancePolicyService
{
    /**
     * Get the active policy for the organization, utilizing cache.
     */
    public function getActivePolicy(Organization $organization): ?AttendancePolicy
    {
        $cacheKey = "org_{$organization->id}_attendance_policy";

        return Cache::remember($cacheKey, 86400, function () use ($organization) {
            return AttendancePolicy::where('organization_id', $organization->id)
                ->with(['latePenaltySlabs', 'workDurationPenaltySlabs'])
                ->first();
        });
    }

    /**
     * Invalidate the policy cache for the organization.
     */
    public function invalidateCache(int $organizationId): void
    {
        Cache::forget("org_{$organizationId}_attendance_policy");
    }

    /**
     * Create default policy for an organization.
     */
    public function createDefaultPolicy(Organization $organization, ?User $actor = null): AttendancePolicy
    {
        return DB::transaction(function () use ($organization, $actor) {
            $policy = AttendancePolicy::create([
                'organization_id' => $organization->id,
                'attendance_mode' => \App\Enums\AttendanceModeEnum::Strict->value,
                'required_daily_minutes' => 480, // 8 hours
                'minimum_session_minutes' => 15,
                'grace_late_minutes' => 15,
                'allowed_monthly_late_count' => 3,
                'default_break_minutes' => 60,
                'worklog_submission_window_days' => 2,
                'worklog_edit_grace_days' => 1,
                'allow_multiple_sessions' => true,
                'allow_clock_in_on_holidays' => false,
                'auto_clock_out_enabled' => false,
                'auto_clock_out_minutes' => 0,
                'strict_worklog_enforcement' => false,
                'shift_start_time' => '09:00:00',
                'created_by' => $actor?->id,
            ]);

            $this->createVersionSnapshot($policy, $actor);
            return $policy;
        });
    }

    /**
     * Update the attendance policy, and clone snapshot for versioning.
     */
    public function updatePolicy(AttendancePolicy $policy, array $data, ?User $actor = null): AttendancePolicy
    {
        return DB::transaction(function () use ($policy, $data, $actor) {
            // Update policy fields
            $policy->update(array_merge($data, [
                'updated_by' => $actor?->id,
            ]));

            // If slabs are provided, update them
            if (isset($data['late_penalty_slabs'])) {
                $policy->latePenaltySlabs()->delete();
                foreach ($data['late_penalty_slabs'] as $slab) {
                    $policy->latePenaltySlabs()->create([
                        'late_count_threshold' => $slab['late_count_threshold'],
                        'deduction_percentage' => $slab['deduction_percentage'],
                    ]);
                }
            }

            if (isset($data['work_duration_penalty_slabs'])) {
                $policy->workDurationPenaltySlabs()->delete();
                foreach ($data['work_duration_penalty_slabs'] as $slab) {
                    $policy->workDurationPenaltySlabs()->create([
                        'min_work_minutes' => $slab['min_work_minutes'],
                        'max_work_minutes' => $slab['max_work_minutes'],
                        'deduction_percentage' => $slab['deduction_percentage'],
                    ]);
                }
            }

            // Invalidate cache
            $this->invalidateCache($policy->organization_id);

            // Increment and save a version snapshot
            $this->createVersionSnapshot($policy, $actor);

            // Reload relationships
            return $policy->load(['latePenaltySlabs', 'workDurationPenaltySlabs']);
        });
    }

    /**
     * Create an immutable snapshot version of the current policy.
     */
    private function createVersionSnapshot(AttendancePolicy $policy, ?User $actor = null): AttendancePolicyVersion
    {
        $nextVersion = ((int) AttendancePolicyVersion::where('attendance_policy_id', $policy->id)->max('version')) + 1;

        return AttendancePolicyVersion::create([
            'attendance_policy_id' => $policy->id,
            'version' => $nextVersion,
            'attendance_mode' => $policy->attendance_mode->value,
            'required_daily_minutes' => $policy->required_daily_minutes,
            'minimum_session_minutes' => $policy->minimum_session_minutes,
            'grace_late_minutes' => $policy->grace_late_minutes,
            'allowed_monthly_late_count' => $policy->allowed_monthly_late_count,
            'default_break_minutes' => $policy->default_break_minutes,
            'worklog_submission_window_days' => $policy->worklog_submission_window_days,
            'worklog_edit_grace_days' => $policy->worklog_edit_grace_days,
            'allow_multiple_sessions' => $policy->allow_multiple_sessions,
            'allow_clock_in_on_holidays' => $policy->allow_clock_in_on_holidays,
            'auto_clock_out_enabled' => $policy->auto_clock_out_enabled,
            'auto_clock_out_minutes' => $policy->auto_clock_out_minutes,
            'strict_worklog_enforcement' => $policy->strict_worklog_enforcement,
            'shift_start_time' => $policy->shift_start_time,
            'created_by' => $actor?->id,
        ]);
    }
}
