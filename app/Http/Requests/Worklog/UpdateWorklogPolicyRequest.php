<?php

declare(strict_types=1);

namespace App\Http\Requests\Worklog;

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
            'worklog_mode' => 'sometimes|required|integer|in:1,2,3',
            'approval_flow' => 'sometimes|required|integer|in:1,2,3',
            'require_worklog_on_clockout' => 'sometimes|required|boolean',
            'allow_deferred_submission' => 'sometimes|required|boolean',
            'submission_window_days' => 'sometimes|required|integer|min:1|max:30',
            'edit_grace_days' => 'sometimes|required|integer|min:0|max:30',
            'lock_after_days' => 'sometimes|required|integer|min:1|max:90',
            'require_description' => 'sometimes|required|boolean',
            'min_description_length' => 'required_if:require_description,true|integer|min:0|max:500',
            'require_justification_on_overflow' => 'sometimes|required|boolean',
            'require_project_mapping' => 'sometimes|required|boolean',
            'require_task_mapping' => 'sometimes|required|boolean',
            'allow_multiple_worklogs_per_session' => 'sometimes|required|boolean',
            'auto_escalate_overdue_logs' => 'sometimes|required|boolean',
            'billable_tracking_enabled' => 'sometimes|required|boolean',
        ];
    }
}
