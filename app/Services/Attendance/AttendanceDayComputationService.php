<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\Attendance\AttendanceMode;
use App\Enums\Attendance\AttendanceStatus;
use App\Enums\Attendance\ComplianceStatus;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicyVersion;
use App\Models\Attendance\AttendanceSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AttendanceDayComputationService
{
    /**
     * Recalculate all aggregate fields on an attendance_day record
     * after a clock-out event and save the result.
     *
     * MUST be called inside a DB::transaction() by the caller.
     *
     * @param AttendanceDay $day
     * @param AttendancePolicyVersion $policyVersion
     * @return void
     */
    public function recompute(AttendanceDay $day, AttendancePolicyVersion $policyVersion): void
    {
        $computed = $this->buildDaySnapshot($day, $policyVersion);

        $day->update($computed);
    }

    /**
     * Build the computed array of attendance day values without saving.
     *
     * @param AttendanceDay $day
     * @param AttendancePolicyVersion $policyVersion
     * @return array
     */
    private function buildDaySnapshot(AttendanceDay $day, AttendancePolicyVersion $policyVersion): array
    {
        // Step 1: Load all sessions for this day ordered by clock_in_at ascending
        $sessions = AttendanceSession::where('attendance_day_id', $day->id)
            ->whereNull('deleted_at')
            ->orderBy('clock_in_at', 'asc')
            ->get();

        $completedSessions = $sessions->whereNotNull('clock_out_at');
        $openSessions = $sessions->whereNull('clock_out_at');

        // Step 2: total_sessions
        $totalSessions = $sessions->count();

        // Step 3: total_work_minutes (completed sessions only)
        $totalWorkMinutes = 0;
        foreach ($completedSessions as $session) {
            $totalWorkMinutes += (int) floor(
                $session->clock_in_at->diffInSeconds($session->clock_out_at) / 60
            );
        }

        // Step 4: total_break_minutes (gaps between consecutive sessions)
        $totalBreakMinutes = $this->computeBreakMinutes($sessions);

        // Step 5: late_minutes (Strict and Hybrid modes only)
        $lateMinutes = $this->computeLateMinutes($sessions, $policyVersion);

        // Step 6: early_exit_minutes (Strict mode only)
        $earlyExitMinutes = $this->computeEarlyExitMinutes($completedSessions, $policyVersion);

        // Step 7: overtime_minutes
        $overtimeMinutes = $this->computeOvertimeMinutes($totalWorkMinutes, $policyVersion);

        // Step 8: attendance_status
        $attendanceStatus = $this->computeAttendanceStatus(
            $openSessions,
            $totalWorkMinutes,
            $policyVersion->required_daily_minutes
        );

        // Step 9: compliance_status
        $complianceStatus = $this->computeComplianceStatus(
            $attendanceStatus,
            $policyVersion->strict_worklog_enforcement
        );

        return [
            'total_sessions' => $totalSessions,
            'total_work_minutes' => $totalWorkMinutes,
            'total_break_minutes' => $totalBreakMinutes,
            'late_minutes' => $lateMinutes,
            'early_exit_minutes' => $earlyExitMinutes,
            'overtime_minutes' => $overtimeMinutes,
            'attendance_status' => $attendanceStatus->value,
            'compliance_status' => $complianceStatus->value,
        ];
    }

    /**
     * Compute break minutes between consecutive sessions.
     *
     * @param Collection $sessions All sessions ordered by clock_in_at
     * @return int
     */
    private function computeBreakMinutes(Collection $sessions): int
    {
        $totalBreak = 0;
        $sessionsArray = $sessions->values()->all();

        for ($i = 0; $i < count($sessionsArray) - 1; $i++) {
            $currentSession = $sessionsArray[$i];
            $nextSession = $sessionsArray[$i + 1];

            if ($currentSession->clock_out_at !== null) {
                $breakSeconds = $currentSession->clock_out_at->diffInSeconds($nextSession->clock_in_at);
                $totalBreak += max(0, (int) floor($breakSeconds / 60));
            }
        }

        return $totalBreak;
    }

    /**
     * Compute late minutes. Only applies in Strict and Hybrid modes.
     *
     * @param Collection $sessions All sessions ordered by clock_in_at
     * @param AttendancePolicyVersion $policyVersion
     * @return int
     */
    private function computeLateMinutes(Collection $sessions, AttendancePolicyVersion $policyVersion): int
    {
        if ($sessions->isEmpty()) {
            return 0;
        }

        $mode = $policyVersion->attendance_mode;

        // Flexible mode → always 0
        if ($mode === AttendanceMode::Flexible) {
            return 0;
        }

        // Strict and Hybrid → compute late from first session
        $firstSession = $sessions->first();
        $clockInAt = $firstSession->clock_in_at;
        $attendanceDate = $clockInAt->copy()->startOfDay();

        $shiftStart = Carbon::parse(
            $attendanceDate->toDateString() . ' ' . $policyVersion->shift_start_time
        );

        $graceCutoff = $shiftStart->copy()->addMinutes($policyVersion->grace_late_minutes);

        if ($clockInAt->gt($graceCutoff)) {
            return (int) floor($shiftStart->diffInSeconds($clockInAt) / 60);
        }

        return 0;
    }

    /**
     * Compute early exit minutes. Only applies in Strict mode.
     *
     * @param Collection $completedSessions Sessions with clock_out_at set
     * @param AttendancePolicyVersion $policyVersion
     * @return int
     */
    private function computeEarlyExitMinutes(Collection $completedSessions, AttendancePolicyVersion $policyVersion): int
    {
        if ($completedSessions->isEmpty()) {
            return 0;
        }

        $mode = $policyVersion->attendance_mode;

        // Only Strict mode computes early exit
        if ($mode !== AttendanceMode::Strict) {
            return 0;
        }

        $lastSession = $completedSessions->last();
        $clockOutAt = $lastSession->clock_out_at;
        $attendanceDate = $lastSession->clock_in_at->copy()->startOfDay();

        $shiftEnd = Carbon::parse(
            $attendanceDate->toDateString() . ' ' . $policyVersion->shift_end_time
        );

        if ($clockOutAt->lt($shiftEnd)) {
            return (int) floor($clockOutAt->diffInSeconds($shiftEnd) / 60);
        }

        return 0;
    }

    /**
     * Compute overtime minutes. Only if overtime is enabled.
     *
     * @param int $totalWorkMinutes
     * @param AttendancePolicyVersion $policyVersion
     * @return int
     */
    private function computeOvertimeMinutes(int $totalWorkMinutes, AttendancePolicyVersion $policyVersion): int
    {
        if (!$policyVersion->overtime_enabled) {
            return 0;
        }

        $overtime = max(0, $totalWorkMinutes - $policyVersion->overtime_starts_after_minutes);

        if ($policyVersion->max_daily_overtime_minutes > 0) {
            $overtime = min($overtime, $policyVersion->max_daily_overtime_minutes);
        }

        return $overtime;
    }

    /**
     * Compute attendance status based on sessions and work minutes.
     *
     * @param Collection $openSessions
     * @param int $totalWorkMinutes
     * @param int $requiredDailyMinutes
     * @return AttendanceStatus
     */
    private function computeAttendanceStatus(
        Collection $openSessions,
        int $totalWorkMinutes,
        int $requiredDailyMinutes
    ): AttendanceStatus {
        // a. Open session → Incomplete
        if ($openSessions->isNotEmpty()) {
            return AttendanceStatus::Incomplete;
        }

        // b. Full day
        if ($totalWorkMinutes >= $requiredDailyMinutes) {
            return AttendanceStatus::Present;
        }

        // c. Half day
        $halfRequired = (int) floor($requiredDailyMinutes / 2);
        if ($totalWorkMinutes >= $halfRequired) {
            return AttendanceStatus::HalfDay;
        }

        // d. Absent
        return AttendanceStatus::Absent;
    }

    /**
     * Compute compliance status.
     *
     * @param AttendanceStatus $attendanceStatus
     * @param bool $strictWorklogEnforcement
     * @return ComplianceStatus
     */
    private function computeComplianceStatus(
        AttendanceStatus $attendanceStatus,
        bool $strictWorklogEnforcement
    ): ComplianceStatus {
        if (
            $strictWorklogEnforcement &&
            in_array($attendanceStatus, [AttendanceStatus::Present, AttendanceStatus::HalfDay], true)
        ) {
            return ComplianceStatus::Pending;
        }

        return ComplianceStatus::Compliant;
    }
}
