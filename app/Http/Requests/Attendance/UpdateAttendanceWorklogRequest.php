<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceWorklogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_uuid' => 'sometimes|nullable|string|exists:projects,uuid',
            'milestone_uuid' => 'sometimes|nullable|string|exists:milestones,uuid',
            'task_uuid' => 'sometimes|nullable|string|exists:tasks,uuid',
            'start_time' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'end_time' => 'sometimes|nullable|date_format:Y-m-d H:i:s|after:start_time',
            'logged_minutes' => 'sometimes|nullable|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'justification' => 'sometimes|nullable|string',
            'metadata' => 'sometimes|nullable|array',
        ];
    }
}
