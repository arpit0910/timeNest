<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendancePolicyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'attendance_mode' => [
                'value' => $this->attendance_mode?->value,
                'label' => $this->attendance_mode?->label(),
                'color' => $this->attendance_mode?->color(),
            ],
            'required_daily_minutes' => $this->required_daily_minutes,
            'minimum_session_minutes' => $this->minimum_session_minutes,
            'grace_late_minutes' => $this->grace_late_minutes,
            'allowed_monthly_late_count' => $this->allowed_monthly_late_count,
            'default_break_minutes' => $this->default_break_minutes,
            'worklog_submission_window_days' => $this->worklog_submission_window_days,
            'worklog_edit_grace_days' => $this->worklog_edit_grace_days,
            'allow_multiple_sessions' => $this->allow_multiple_sessions,
            'allow_clock_in_on_holidays' => $this->allow_clock_in_on_holidays,
            'auto_clock_out_enabled' => $this->auto_clock_out_enabled,
            'auto_clock_out_minutes' => $this->auto_clock_out_minutes,
            'strict_worklog_enforcement' => $this->strict_worklog_enforcement,
            'shift_start_time' => $this->shift_start_time,
            'late_penalty_slabs' => $this->latePenaltySlabs->map(fn($slab) => [
                'late_count_threshold' => $slab->late_count_threshold,
                'deduction_percentage' => (float) $slab->deduction_percentage,
            ]),
            'work_duration_penalty_slabs' => $this->workDurationPenaltySlabs->map(fn($slab) => [
                'min_work_minutes' => $slab->min_work_minutes,
                'max_work_minutes' => $slab->max_work_minutes,
                'deduction_percentage' => (float) $slab->deduction_percentage,
            ]),
        ];
    }
}
