<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\AttendanceModeEnum;
use App\Enums\AttendanceStatusEnum;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendancePolicy;
use App\Models\Attendance\OrganizationHoliday;
use App\Models\Leave\EmployeeLeave;
use App\Models\Auth\User;
use App\Models\Membership\EmployeeProfile;
use Carbon\Carbon;

class AttendanceCalculationService
{
    public function __construct(
        private readonly LeaveManagementService $leaveManagementService,
        private readonly AttendancePolicyService $policyService,
    ) {}

    /**
     * Recalculate daily attendance aggregates and statuses.
     */
    public function recalculateDay(AttendanceDay $attendanceDay): AttendanceDay
    {
        $user = $attendanceDay->user;
        $organization = $attendanceDay->organization;
        $dateStr = $attendanceDay->attendance_date->toDateString();

        // Get policy active at the time
        $policy = $this->policyService->getPolicy($organization);
        if (! $policy) {
            return $attendanceDay; // No policy, cannot compute
        }

        // Get all active sessions for this day sorted by clock_in_at
        $sessions = $attendanceDay->attendanceSessions()
            ->whereNull('deleted_at')
            ->orderBy('clock_in_at')
            ->get();

        $totalWorkMinutes = 0;
        $totalBreakMinutes = 0;
        $totalSessions = $sessions->count();
        $lateMinutes = 0;
        $overtimeMinutes = 0;

        // Fetch user timezone (fallback to UTC)
        $profile = EmployeeProfile::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->with('branch')
            ->first();
        $timezone = $profile?->branch?->timezone ?? $user->timezone ?? 'UTC';

        if ($totalSessions > 0) {
            // 1. Calculate total work minutes
            foreach ($sessions as $session) {
                if ($session->clock_out_at) {
                    $totalWorkMinutes += (int) $session->clock_out_at->diffInMinutes($session->clock_in_at, true);
                }
            }

            // 2. Calculate break minutes (gaps between sessions)
            for ($i = 0; $i < $totalSessions - 1; $i++) {
                $currentOut = $sessions[$i]->clock_out_at;
                $nextIn = $sessions[$i + 1]->clock_in_at;

                if ($currentOut && $nextIn) {
                    $totalBreakMinutes += (int) $nextIn->diffInMinutes($currentOut, true);
                }
            }

            // 3. Calculate late minutes from the first session (only for Strict mode)
            if ($policy->attendance_mode === AttendanceModeEnum::Strict) {
                $firstSession = $sessions->first();
                $localClockIn = $firstSession->clock_in_at->copy()->tz($timezone);
                
                // Parse target shift start time on the local clock in date
                $shiftStart = Carbon::parse($localClockIn->toDateString() . ' ' . $policy->shift_start_time, $timezone);
                $graceTime = $shiftStart->copy()->addMinutes($policy->grace_late_minutes);

                if ($localClockIn->gt($graceTime)) {
                    $lateMinutes = (int) $localClockIn->diffInMinutes($shiftStart, true);
                }
            }

            // 4. Calculate overtime
            if ($totalWorkMinutes > $policy->required_daily_minutes) {
                $overtimeMinutes = $totalWorkMinutes - $policy->required_daily_minutes;
            }
        }

        // Determine Attendance Status
        $attendanceStatus = AttendanceStatusEnum::Absent;
        $complianceStatus = AttendanceComplianceStatusEnum::Compliant;

        // Check if there is an approved leave
        $isLeave = $this->leaveManagementService->hasApprovedLeave($user->id, $dateStr);
        // Check if it's a holiday
        $isHoliday = $this->isHoliday($organization->id, $profile?->branch_id, $dateStr);
        // Check if it's a weekend
        $isWeekend = $this->isWeekend($dateStr, $timezone);

        if ($totalSessions === 0) {
            if ($isLeave) {
                $attendanceStatus = AttendanceStatusEnum::Leave;
            } elseif ($isHoliday) {
                $attendanceStatus = AttendanceStatusEnum::Holiday;
            } elseif ($isWeekend) {
                $attendanceStatus = AttendanceStatusEnum::Weekend;
            } else {
                $attendanceStatus = AttendanceStatusEnum::Absent;
                $complianceStatus = AttendanceComplianceStatusEnum::Overdue; // Unexcused absence
            }
        } else {
            // User worked
            $hasOpenSession = $sessions->whereNull('clock_out_at')->isNotEmpty();

            if ($hasOpenSession && $attendanceDay->attendance_date->isToday()) {
                $attendanceStatus = AttendanceStatusEnum::Incomplete; // Still working
                $complianceStatus = AttendanceComplianceStatusEnum::Pending;
            } else {
                // All sessions closed, check work hours against policy and slabs
                $minRequired = $policy->required_daily_minutes;
                
                if ($totalWorkMinutes >= $minRequired) {
                    $attendanceStatus = AttendanceStatusEnum::Present;
                } else {
                    // Check if they hit half-day threshold (either 50% of required, or custom slab)
                    $halfDayThreshold = (int) ($minRequired / 2);
                    
                    // Let's check work duration slabs to see if there is any deduction
                    $slabs = $policy->workDurationPenaltySlabs()->orderBy('min_work_minutes')->get();
                    $deduction = 0;
                    foreach ($slabs as $slab) {
                        if ($totalWorkMinutes >= $slab->min_work_minutes && $totalWorkMinutes <= $slab->max_work_minutes) {
                            $deduction = (float) $slab->deduction_percentage;
                            break;
                        }
                    }

                    if ($deduction >= 100.0) {
                        $attendanceStatus = AttendanceStatusEnum::Absent;
                        $complianceStatus = AttendanceComplianceStatusEnum::PayrollRisk;
                    } elseif ($deduction >= 50.0 || $totalWorkMinutes >= $halfDayThreshold) {
                        $attendanceStatus = AttendanceStatusEnum::HalfDay;
                        $complianceStatus = AttendanceComplianceStatusEnum::Pending;
                    } else {
                        $attendanceStatus = AttendanceStatusEnum::Incomplete;
                        $complianceStatus = AttendanceComplianceStatusEnum::Pending;
                    }
                }

                // If late, check compliance and monthly limits
                if ($lateMinutes > 0) {
                    $monthlyLateCount = $this->getMonthlyLateCount($user->id, $organization->id, $attendanceDay->attendance_date);
                    if ($monthlyLateCount > $policy->allowed_monthly_late_count) {
                        $complianceStatus = AttendanceComplianceStatusEnum::PayrollRisk;
                    } else {
                        // Late but within grace count
                        if ($complianceStatus === AttendanceComplianceStatusEnum::Compliant) {
                            $complianceStatus = AttendanceComplianceStatusEnum::Pending;
                        }
                    }
                }
            }
        }

        // Save aggregates
        $attendanceDay->update([
            'total_work_minutes' => $totalWorkMinutes,
            'total_break_minutes' => $totalBreakMinutes,
            'total_sessions' => $totalSessions,
            'late_minutes' => $lateMinutes,
            'overtime_minutes' => $overtimeMinutes,
            'attendance_status' => $attendanceStatus->value,
            'compliance_status' => $complianceStatus->value,
        ]);

        // Integrate Phase 2 Worklog Compliance rules
        $worklogPolicy = \App\Models\Attendance\WorklogPolicy::where('attendance_policy_id', $policy->id)->first();
        if ($worklogPolicy && $totalSessions > 0) {
            $hasOpenSession = $sessions->whereNull('clock_out_at')->isNotEmpty();
            if (! $hasOpenSession) {
                if ($worklogPolicy->strict_mode_enabled || $worklogPolicy->require_worklog_on_clockout) {
                    // Check if there is at least one submitted or approved worklog
                    $hasSubmittedWorklog = $attendanceDay->worklogs()
                        ->whereIn('worklog_status', [
                            \App\Enums\WorkflowStatusEnum::Submitted->value,
                            \App\Enums\WorkflowStatusEnum::Approved->value,
                            \App\Enums\WorkflowStatusEnum::Locked->value
                        ])->exists();
                    
                    if (! $hasSubmittedWorklog) {
                        $attendanceDay->update([
                            'attendance_status' => AttendanceStatusEnum::Incomplete->value,
                        ]);
                    }
                }

                // If project/task mapping is required, verify all worklogs comply
                if ($worklogPolicy->require_project_mapping) {
                    $hasMissingProject = $attendanceDay->worklogs()
                        ->whereNull('project_id')
                        ->exists();
                    if ($hasMissingProject) {
                        $attendanceDay->update([
                            'attendance_status' => AttendanceStatusEnum::Incomplete->value,
                        ]);
                    }
                }

                if ($worklogPolicy->require_task_mapping) {
                    $hasMissingTask = $attendanceDay->worklogs()
                        ->whereNull('task_id')
                        ->exists();
                    if ($hasMissingTask) {
                        $attendanceDay->update([
                            'attendance_status' => AttendanceStatusEnum::Incomplete->value,
                        ]);
                    }
                }
            }
        }

        return $attendanceDay;
    }

    /**
     * Check if a date is a holiday for the organization or branch.
     */
    public function isHoliday(int $organizationId, ?int $branchId, string $date): bool
    {
        $query = OrganizationHoliday::active()
            ->where('organization_id', $organizationId)
            ->where('holiday_date', $date);

        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        } else {
            $query->whereNull('branch_id');
        }

        return $query->exists();
    }

    /**
     * Check if a date falls on a weekend in the given timezone.
     */
    public function isWeekend(string $date, string $timezone): bool
    {
        $carbon = Carbon::parse($date, $timezone);
        return $carbon->isWeekend();
    }

    /**
     * Count the number of late arrivals for the user in the given month.
     */
    private function getMonthlyLateCount(int $userId, int $organizationId, Carbon $date): int
    {
        $startOfMonth = $date->copy()->startOfMonth()->toDateString();
        $endOfMonth = $date->copy()->endOfMonth()->toDateString();

        return (int) AttendanceDay::where('user_id', $userId)
            ->where('organization_id', $organizationId)
            ->whereBetween('attendance_date', [$startOfMonth, $endOfMonth])
            ->where('late_minutes', '>', 0)
            ->count();
    }
}
