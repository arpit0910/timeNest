<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\Attendance\AttendanceStatus;
use App\Enums\Attendance\ClockSource;
use App\Enums\Attendance\ComplianceStatus;
use App\Exceptions\Attendance\AlreadyClockedInException;
use App\Exceptions\Attendance\ClockInNotAllowedOnHolidayException;
use App\Exceptions\Attendance\ClockInNotAllowedOnWeekendException;
use App\Exceptions\Attendance\MultipleSessionsNotAllowedException;
use App\Exceptions\Attendance\NoActiveSessionException;
use App\Exceptions\Attendance\WorklogEnforcementBlockException;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Attendance\OrganizationHoliday;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AttendanceClockService
{
    public function __construct(
        private readonly AttendancePolicyService $policyService,
        private readonly AttendanceDayComputationService $computationService,
    ) {}

    /**
     * Clock in an employee for the current day.
     *
     * @param Organization $organization
     * @param User $user
     * @param array $data
     * @return AttendanceSession
     */
    public function clockIn(Organization $organization, User $user, array $data): AttendanceSession
    {
        $policy = $this->policyService->getPolicy($organization);
        $policyVersion = $this->policyService->resolveCurrentVersion($policy);
        $today = Carbon::today();

        $this->validateClockIn($organization, $user, $policy, $policyVersion, $today, $data);

        return DB::transaction(function () use ($organization, $user, $data, $policyVersion, $today) {
            // Find or create attendance_day for today
            $day = AttendanceDay::where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->where('attendance_date', $today->toDateString())
                ->first();

            if (!$day) {
                $day = AttendanceDay::create([
                    'user_id' => $user->id,
                    'organization_id' => $organization->id,
                    'attendance_date' => $today->toDateString(),
                    'attendance_status' => AttendanceStatus::Incomplete->value,
                    'compliance_status' => ComplianceStatus::Pending->value,
                    'attendance_policy_version_id' => $policyVersion->id,
                    'approval_flow_snapshot' => $policyVersion->approval_flow->value,
                    'total_work_minutes' => 0,
                    'total_break_minutes' => 0,
                    'total_sessions' => 0,
                    'late_minutes' => 0,
                    'early_exit_minutes' => 0,
                    'overtime_minutes' => 0,
                ]);
            }

            // Create the session
            $session = AttendanceSession::create([
                'attendance_day_id' => $day->id,
                'clock_in_at' => Carbon::now(),
                'clock_in_source' => $data['clock_in_source'],
                'clock_in_ip' => $data['clock_in_ip'] ?? null,
                'clock_in_device_id' => $data['clock_in_device_id'] ?? null,
                'clock_in_latitude' => $data['clock_in_latitude'] ?? null,
                'clock_in_longitude' => $data['clock_in_longitude'] ?? null,
                'clock_in_accuracy' => $data['clock_in_accuracy'] ?? null,
                'is_suspicious' => $data['_suspicious'] ?? false,
                'suspicious_reason' => $data['_suspicious_reason'] ?? null,
            ]);

            return $session->load('attendanceDay');
        });
    }

    /**
     * Clock out an employee from their active session.
     *
     * @param Organization $organization
     * @param User $user
     * @param array $data
     * @return AttendanceSession
     */
    public function clockOut(Organization $organization, User $user, array $data): AttendanceSession
    {
        $today = Carbon::today();

        // Find the open session for today
        $session = AttendanceSession::whereHas('attendanceDay', function ($query) use ($user, $organization, $today) {
            $query->where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->where('attendance_date', $today->toDateString());
        })
            ->whereNull('clock_out_at')
            ->first();

        if (!$session) {
            throw new NoActiveSessionException();
        }

        return DB::transaction(function () use ($session, $data) {
            // Update the session with clock-out data
            $session->update([
                'clock_out_at' => Carbon::now(),
                'clock_out_source' => $data['clock_out_source'],
                'clock_out_ip' => $data['clock_out_ip'] ?? null,
                'clock_out_device_id' => $data['clock_out_device_id'] ?? null,
                'clock_out_latitude' => $data['clock_out_latitude'] ?? null,
                'clock_out_longitude' => $data['clock_out_longitude'] ?? null,
                'clock_out_accuracy' => $data['clock_out_accuracy'] ?? null,
            ]);

            // IMPORTANT: Use the version stamped on the day at creation, NOT resolveCurrentVersion
            $day = $session->attendanceDay;
            $policyVersion = AttendancePolicyVersion::find($day->attendance_policy_version_id);

            $this->computationService->recompute($day, $policyVersion);

            return $session->fresh(['attendanceDay']);
        });
    }

    /**
     * Get today's attendance day for the user in this org.
     *
     * @param Organization $organization
     * @param User $user
     * @return AttendanceDay|null
     */
    public function getTodayAttendance(Organization $organization, User $user): ?AttendanceDay
    {
        return AttendanceDay::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->where('attendance_date', Carbon::today()->toDateString())
            ->with(['attendanceSessions', 'policyVersion'])
            ->first();
    }

    /**
     * Get paginated attendance history for the user in this org.
     *
     * @param Organization $organization
     * @param User $user
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAttendanceHistory(Organization $organization, User $user, array $filters): LengthAwarePaginator
    {
        $query = AttendanceDay::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->with('attendanceSessions')
            ->orderBy('attendance_date', 'desc');

        if (!empty($filters['start_date'])) {
            $query->where('attendance_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('attendance_date', '<=', $filters['end_date']);
        }

        if (!empty($filters['attendance_status'])) {
            $query->where('attendance_status', $filters['attendance_status']);
        }

        $perPage = $filters['per_page'] ?? 30;

        return $query->paginate((int) $perPage);
    }

    /**
     * Validate all policy rules before allowing a clock-in.
     *
     * @param Organization $organization
     * @param User $user
     * @param AttendancePolicy $policy
     * @param AttendancePolicyVersion $policyVersion
     * @param Carbon $today
     * @return void
     */
    private function validateClockIn(
        Organization $organization,
        User $user,
        AttendancePolicy $policy,
        AttendancePolicyVersion $policyVersion,
        Carbon $today,
        array &$data
    ): void {
        $todayDate = $today->toDateString();

        // Geo-fencing check
        if ($policyVersion->geo_fencing_enabled) {
            $branches = \App\Models\Organization\Branch::where('organization_id', $organization->id)
                ->where('is_active', true)
                ->get();

            if ($branches->isNotEmpty()) {
                $empLat = $data['clock_in_latitude'] ?? null;
                $empLng = $data['clock_in_longitude'] ?? null;

                if ($empLat === null || $empLng === null) {
                    // No coordinates provided
                    if ($policyVersion->attendance_mode === \App\Enums\Attendance\AttendanceMode::Strict) {
                        throw new \App\Exceptions\Attendance\ClockInOutsideGeofenceException();
                    }
                    // Flexible and Hybrid: allow but flag suspicious
                    $data['_suspicious'] = true;
                    $data['_suspicious_reason'] = 'Location not provided but geo-fencing is enabled.';
                } else {
                    $isWithin = $this->isWithinAnyBranchGeofence(
                        $organization,
                        (float) $empLat,
                        (float) $empLng,
                        $policyVersion->geo_fence_radius_meters
                    );

                    if (!$isWithin) {
                        if ($policyVersion->attendance_mode === \App\Enums\Attendance\AttendanceMode::Strict) {
                            throw new \App\Exceptions\Attendance\ClockInOutsideGeofenceException();
                        }
                        
                        $nearest = $this->getNearestBranchDistance($organization, (float) $empLat, (float) $empLng);
                        $distanceMsg = $nearest 
                            ? sprintf('%.0f meters from nearest branch (%s)', $nearest['distance'], $nearest['branch_name'])
                            : 'unknown distance';

                        // Flexible and Hybrid: allow but flag suspicious
                        $data['_suspicious'] = true;
                        $data['_suspicious_reason'] = sprintf(
                            'Location is %s. Closest allowed radius is %d meters.',
                            $distanceMsg,
                            $policyVersion->geo_fence_radius_meters
                        );
                    }
                }
            }
        }

        // 1. Open session check
        $hasOpenSession = AttendanceSession::whereHas('attendanceDay', function ($query) use ($user, $organization, $todayDate) {
            $query->where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->where('attendance_date', $todayDate);
        })
            ->whereNull('clock_out_at')
            ->exists();

        if ($hasOpenSession) {
            throw new AlreadyClockedInException();
        }

        // 2. Multiple sessions check
        if (!$policyVersion->allow_multiple_sessions) {
            $hasAnySession = AttendanceSession::whereHas('attendanceDay', function ($query) use ($user, $organization, $todayDate) {
                $query->where('user_id', $user->id)
                    ->where('organization_id', $organization->id)
                    ->where('attendance_date', $todayDate);
            })->exists();

            if ($hasAnySession) {
                throw new MultipleSessionsNotAllowedException();
            }
        }

        // 3. Weekend check
        $weekendDays = $policyVersion->weekend_days ?? [];
        $todayDayOfWeek = $today->isoWeekday(); // 1=Mon, 7=Sun

        if (in_array($todayDayOfWeek, $weekendDays, false)) {
            if (!$policyVersion->allow_clock_in_on_holidays) {
                throw new ClockInNotAllowedOnWeekendException();
            }
        }

        // 4. Holiday check
        $isHoliday = OrganizationHoliday::where('organization_id', $organization->id)
            ->whereNull('deleted_at')
            ->where(function ($query) use ($today) {
                $query->where('holiday_date', $today->toDateString())
                    ->orWhere(function ($q) use ($today) {
                        $q->where('is_recurring', true)
                            ->whereMonth('holiday_date', $today->month)
                            ->whereDay('holiday_date', $today->day);
                    });
            })
            ->exists();

        if ($isHoliday && !$policyVersion->allow_clock_in_on_holidays) {
            throw new ClockInNotAllowedOnHolidayException();
        }

        // 5. Worklog enforcement check
        if ($policyVersion->strict_worklog_enforcement) {
            $this->checkWorklogEnforcement($organization, $user, $policyVersion, $today);
        }
    }

    /**
     * Check worklog enforcement for the previous working day.
     *
     * @param Organization $organization
     * @param User $user
     * @param AttendancePolicyVersion $policyVersion
     * @param Carbon $today
     * @return void
     */
    private function checkWorklogEnforcement(
        Organization $organization,
        User $user,
        AttendancePolicyVersion $policyVersion,
        Carbon $today
    ): void {
        $weekendDays = $policyVersion->weekend_days ?? [];
        $previousWorkingDay = null;

        // Look back up to 7 days to find the previous working day
        for ($i = 1; $i <= 7; $i++) {
            $candidate = $today->copy()->subDays($i);
            $candidateDayOfWeek = $candidate->isoWeekday();

            // Skip if weekend
            if (in_array($candidateDayOfWeek, $weekendDays, false)) {
                continue;
            }

            // Skip if holiday
            $isHoliday = OrganizationHoliday::where('organization_id', $organization->id)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($candidate) {
                    $query->where('holiday_date', $candidate->toDateString())
                        ->orWhere(function ($q) use ($candidate) {
                            $q->where('is_recurring', true)
                                ->whereMonth('holiday_date', $candidate->month)
                                ->whereDay('holiday_date', $candidate->day);
                        });
                })
                ->exists();

            if (!$isHoliday) {
                $previousWorkingDay = $candidate;
                break;
            }
        }

        if (!$previousWorkingDay) {
            return; // No previous working day found within 7 days, skip enforcement
        }

        // Check if attendance_day exists for that date with Present or HalfDay status
        $previousDay = AttendanceDay::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->where('attendance_date', $previousWorkingDay->toDateString())
            ->whereIn('attendance_status', [
                AttendanceStatus::Present->value,
                AttendanceStatus::HalfDay->value,
            ])
            ->first();

        if (!$previousDay) {
            return; // No worked day found, no enforcement needed
        }

        // Check for submitted worklog (not Draft)
        $hasSubmittedWorklog = AttendanceWorklog::where('attendance_day_id', $previousDay->id)
            ->where('worklog_status', '!=', 1) // 1 = Draft status
            ->exists();

        if (!$hasSubmittedWorklog) {
            throw new WorklogEnforcementBlockException();
        }
    }

    /**
     * Calculate Haversine distance between two coordinates in meters.
     */
    private function haversineDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    /**
     * Check if employee is within the allowed radius of ANY active branch.
     */
    private function isWithinAnyBranchGeofence(
        Organization $organization,
        float $empLat,
        float $empLng,
        int $fallbackRadiusMeters
    ): bool {
        $branches = \App\Models\Organization\Branch::where('organization_id', $organization->id)
            ->where('is_active', true)
            ->get();

        if ($branches->isEmpty()) {
            return false;
        }

        foreach ($branches as $branch) {
            if ($branch->latitude !== null && $branch->longitude !== null) {
                $distance = $this->haversineDistance(
                    (float) $branch->latitude,
                    (float) $branch->longitude,
                    $empLat,
                    $empLng
                );

                $radius = $branch->geo_fence_radius > 0 
                    ? $branch->geo_fence_radius 
                    : $fallbackRadiusMeters;

                if ($distance <= $radius) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the nearest active branch and its distance.
     */
    private function getNearestBranchDistance(
        Organization $organization,
        float $empLat,
        float $empLng
    ): ?array {
        $branches = \App\Models\Organization\Branch::where('organization_id', $organization->id)
            ->where('is_active', true)
            ->get();

        if ($branches->isEmpty()) {
            return null;
        }

        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($branches as $branch) {
            if ($branch->latitude !== null && $branch->longitude !== null) {
                $distance = $this->haversineDistance(
                    (float) $branch->latitude,
                    (float) $branch->longitude,
                    $empLat,
                    $empLng
                );

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $nearest = [
                        'distance' => $distance,
                        'branch_name' => $branch->name,
                    ];
                }
            }
        }

        return $nearest;
    }
}
