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

        $this->validateClockIn($organization, $user, $policy, $policyVersion, $today);

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

            // Determine geo-fence suspicion
            $isSuspicious = false;
            $suspiciousReason = null;

            if (
                $policyVersion->geo_fencing_enabled &&
                (empty($data['clock_in_latitude']) || empty($data['clock_in_longitude']))
            ) {
                $isSuspicious = true;
                $suspiciousReason = 'Location not provided but geo-fencing is enabled';
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
                'is_suspicious' => $isSuspicious,
                'suspicious_reason' => $suspiciousReason,
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
        Carbon $today
    ): void {
        $todayDate = $today->toDateString();

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
}
