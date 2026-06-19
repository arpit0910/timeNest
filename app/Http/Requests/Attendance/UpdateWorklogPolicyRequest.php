<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorklogPolicyRequest extends FormRequest
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
            'require_worklog_on_clockout' => 'sometimes|boolean',
            'allow_deferred_submission' => 'sometimes|boolean',
            'require_project_mapping' => 'sometimes|boolean',
            'require_task_mapping' => 'sometimes|boolean',
            'require_justification_on_overflow' => 'sometimes|boolean',
            'auto_escalate_overdue_logs' => 'sometimes|boolean',
            'overdue_after_days' => 'sometimes|integer|min:0|max:255',
            'lock_after_days' => 'sometimes|integer|min:0|max:255',
            'allow_multiple_worklogs_per_session' => 'sometimes|boolean',
            'strict_mode_enabled' => 'sometimes|boolean',
            'flexible_mode_enabled' => 'sometimes|boolean',
            'hybrid_mode_enabled' => 'sometimes|boolean',
        ];
    }
}
