<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceWorklogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_day_uuid' => 'required|string|exists:attendance_days,uuid',
            'attendance_session_uuid' => 'nullable|string|exists:attendance_sessions,uuid',
            'project_uuid' => 'nullable|string|exists:projects,uuid',
            'milestone_uuid' => 'nullable|string|exists:milestones,uuid',
            'task_uuid' => 'nullable|string|exists:tasks,uuid',
            'start_time' => 'nullable|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s|after:start_time',
            'logged_minutes' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'justification' => 'nullable|string',
            'metadata' => 'nullable|array',
        ];
    }
}
