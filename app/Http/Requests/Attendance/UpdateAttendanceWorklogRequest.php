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
            // Deprecated raw-id fields: reject explicitly rather than silently
            // dropping them, which used to update a worklog with a missing
            // association instead of telling the client what went wrong.
            'project_id' => 'prohibited',
            'milestone_id' => 'prohibited',
            'task_id' => 'prohibited',
            'start_time' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'end_time' => 'sometimes|nullable|date_format:Y-m-d H:i:s|after:start_time',
            'logged_minutes' => 'sometimes|nullable|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'justification' => 'sometimes|nullable|string',
            'metadata' => 'sometimes|nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.prohibited' => 'project_id is deprecated; use project_uuid instead.',
            'milestone_id.prohibited' => 'milestone_id is deprecated; use milestone_uuid instead.',
            'task_id.prohibited' => 'task_id is deprecated; use task_uuid instead.',
        ];
    }
}
