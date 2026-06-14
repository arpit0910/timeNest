<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttendancePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Assuming user has a method to check permissions.
        // We will return true here and rely on middleware or gate.
        // But prompt says: "User must have permission 'attendance.policy.create' on the current organization. Use Gate or a policy check."
        
        $user = $this->user();
        if (!$user) {
            return false;
        }

        // Ideally checking via Spatie permissions or Gate
        return $user->can('attendance.policy.create');
    }

    public function rules(): array
    {
        return [
            'attendance_mode' => 'required|integer|in:1,2,3',
            'approval_flow' => 'required|integer|in:1,2,3',
            'shift_start_time' => 'required|date_format:H:i:s',
            'shift_end_time' => 'required|date_format:H:i:s',
            'required_daily_minutes' => 'required|integer|min:1|max:1440',
            'minimum_session_minutes' => 'required|integer|min:1|max:1440',
            'grace_late_minutes' => 'required|integer|min:0|max:120',
            'allowed_monthly_late_count' => 'required|integer|min:0|max:31',
            'allow_early_exit' => 'required|boolean',
            'grace_early_exit_minutes' => 'required_if:allow_early_exit,true|integer|min:0|max:120',
            'default_break_minutes' => 'required|integer|min:0|max:480',
            'max_break_minutes' => 'required|integer|min:0|max:480',
            'allow_multiple_sessions' => 'required|boolean',
            'allow_clock_in_on_holidays' => 'required|boolean',
            'auto_clock_out_enabled' => 'required|boolean',
            'auto_clock_out_after_minutes' => 'required_if:auto_clock_out_enabled,true|integer|min:30|max:1440',
            'overtime_enabled' => 'required|boolean',
            'overtime_starts_after_minutes' => 'required_if:overtime_enabled,true|integer|min:1|max:1440',
            'max_daily_overtime_minutes' => 'nullable|integer|min:0|max:480',
            'overtime_requires_approval' => 'required_if:overtime_enabled,true|boolean',
            'weekend_days' => 'required|array|min:1',
            'weekend_days.*' => 'integer|in:1,2,3,4,5,6,7',
            'geo_fencing_enabled' => 'required|boolean',
            'geo_fence_radius_meters' => 'required_if:geo_fencing_enabled,true|integer|min:50|max:50000',
            'ip_restriction_enabled' => 'required|boolean',
            'strict_worklog_enforcement' => 'required|boolean',

            'late_penalty_slabs' => 'nullable|array',
            'late_penalty_slabs.*.late_count_threshold' => 'required|integer|min:1|max:31',
            'late_penalty_slabs.*.deduction_percentage' => 'required|numeric|min:0.01|max:100',

            'work_duration_penalty_slabs' => 'nullable|array',
            'work_duration_penalty_slabs.*.min_work_minutes' => 'required|integer|min:0',
            'work_duration_penalty_slabs.*.max_work_minutes' => 'required|integer|min:1',
            'work_duration_penalty_slabs.*.deduction_percentage' => 'required|numeric|min:0.01|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'attendance_mode.in' => 'The selected attendance mode is invalid.',
            'approval_flow.in' => 'The selected approval flow is invalid.',
            'shift_start_time.date_format' => 'The shift start time must be in H:i:s format.',
            'shift_end_time.date_format' => 'The shift end time must be in H:i:s format.',
            'grace_early_exit_minutes.required_if' => 'Grace early exit minutes is required when allow early exit is true.',
            'auto_clock_out_after_minutes.required_if' => 'Auto clock out minutes is required when auto clock out is enabled.',
            'overtime_starts_after_minutes.required_if' => 'Overtime starts after minutes is required when overtime is enabled.',
            'overtime_requires_approval.required_if' => 'Overtime requires approval flag is required when overtime is enabled.',
            'weekend_days.*.in' => 'Weekend days must be valid ISO weekday integers (1-7).',
            'geo_fence_radius_meters.required_if' => 'Geo fence radius is required when geo fencing is enabled.',
        ];
    }
}
