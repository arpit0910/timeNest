<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendancePolicyVersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->version, // Export version number as 'id' per specs
            'version' => $this->version,
            'attendance_policy_uuid' => $this->policy->uuid ?? null,
            'attendance_mode' => [
                'value' => $this->attendance_mode->value,
                'label' => $this->attendance_mode->label(),
                'description' => $this->attendance_mode->description(),
            ],
            'approval_flow' => [
                'value' => $this->approval_flow->value,
                'label' => $this->approval_flow->label(),
                'description' => $this->approval_flow->description(),
                'requires_approver' => $this->approval_flow->requiresApprover(),
                'requires_second_approver' => $this->approval_flow->requiresSecondApprover(),
            ],
            'shift_start_time' => $this->shift_start_time,
            'shift_end_time' => $this->shift_end_time,
            'required_daily_minutes' => $this->required_daily_minutes,
            'minimum_session_minutes' => $this->minimum_session_minutes,
            'grace_late_minutes' => $this->grace_late_minutes,
            'allowed_monthly_late_count' => $this->allowed_monthly_late_count,
            'allow_early_exit' => $this->allow_early_exit,
            'grace_early_exit_minutes' => $this->grace_early_exit_minutes,
            'default_break_minutes' => $this->default_break_minutes,
            'max_break_minutes' => $this->max_break_minutes,
            'allow_multiple_sessions' => $this->allow_multiple_sessions,
            'allow_clock_in_on_holidays' => $this->allow_clock_in_on_holidays,
            'auto_clock_out_enabled' => $this->auto_clock_out_enabled,
            'auto_clock_out_after_minutes' => $this->auto_clock_out_after_minutes,
            'overtime_enabled' => $this->overtime_enabled,
            'overtime_starts_after_minutes' => $this->overtime_starts_after_minutes,
            'max_daily_overtime_minutes' => $this->max_daily_overtime_minutes,
            'overtime_requires_approval' => $this->overtime_requires_approval,
            'weekend_days' => $this->weekend_days,
            'geo_fencing_enabled' => $this->geo_fencing_enabled,
            'geo_fence_radius_meters' => $this->geo_fence_radius_meters,
            'ip_restriction_enabled' => $this->ip_restriction_enabled,
            'strict_worklog_enforcement' => $this->strict_worklog_enforcement,
            'created_by_uuid' => $this->createdBy->uuid ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
