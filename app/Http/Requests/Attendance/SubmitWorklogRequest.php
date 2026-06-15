<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class SubmitWorklogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_session_id' => ['nullable', 'string', 'uuid'],
            'logged_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'description' => ['nullable', 'string', 'max:2000'],
            'justification' => ['nullable', 'string', 'max:1000'],
            'project_id' => ['nullable', 'integer', 'min:1'],
            'milestone_id' => ['nullable', 'integer', 'min:1'],
            'task_id' => ['nullable', 'integer', 'min:1'],
            'billable' => ['nullable', 'boolean'],
            'start_time' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'end_time' => ['nullable', 'date_format:Y-m-d H:i:s', 'after_or_equal:start_time'],
        ];
    }
}
