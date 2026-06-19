<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use App\Enums\AttendanceModeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled by route 'permission:' middleware + 
        // $this->authorize() in the controller — not duplicated here.
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_mode' => ['required', new Enum(AttendanceModeEnum::class)],
            'required_daily_minutes' => ['required', 'integer', 'min:1'],
            'minimum_session_minutes' => ['required', 'integer', 'min:1'],
            'grace_late_minutes' => ['required', 'integer', 'min:0'],
            'allowed_monthly_late_count' => ['required', 'integer', 'min:0'],
            'default_break_minutes' => ['required', 'integer', 'min:0'],
            'worklog_submission_window_days' => ['required', 'integer', 'min:0'],
            'worklog_edit_grace_days' => ['required', 'integer', 'min:0'],
            'allow_multiple_sessions' => ['required', 'boolean'],
            'allow_clock_in_on_holidays' => ['required', 'boolean'],
            'auto_clock_out_enabled' => ['required', 'boolean'],
            'auto_clock_out_minutes' => ['required', 'integer', 'min:0'],
            'strict_worklog_enforcement' => ['required', 'boolean'],
            'shift_start_time' => ['required', 'date_format:H:i:s'],
            
            'late_penalty_slabs' => ['nullable', 'array'],
            'late_penalty_slabs.*.late_count_threshold' => ['required', 'integer', 'min:1'],
            'late_penalty_slabs.*.deduction_percentage' => ['required', 'numeric', 'between:0,100'],
            
            'work_duration_penalty_slabs' => ['nullable', 'array'],
            'work_duration_penalty_slabs.*.min_work_minutes' => ['required', 'integer', 'min:0'],
            'work_duration_penalty_slabs.*.max_work_minutes' => ['required', 'integer', 'gt:work_duration_penalty_slabs.*.min_work_minutes'],
            'work_duration_penalty_slabs.*.deduction_percentage' => ['required', 'numeric', 'between:0,100'],
        ];
    }
}
