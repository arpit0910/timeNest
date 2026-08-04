<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'worklog_mode' => ['sometimes', Rule::enum(\App\Enums\Worklog\WorklogMode::class)],
            'approval_flow' => ['sometimes', Rule::enum(\App\Enums\Worklog\ApprovalFlow::class)],
            'require_worklog_on_clockout' => 'sometimes|boolean',
            'allow_deferred_submission' => 'sometimes|boolean',
            'require_project_mapping' => 'sometimes|boolean',
            'require_task_mapping' => 'sometimes|boolean',
            'require_justification_on_overflow' => 'sometimes|boolean',
            'auto_escalate_overdue_logs' => 'sometimes|boolean',
            'submission_window_days' => 'sometimes|integer|min:0|max:255',
            'edit_grace_days' => 'sometimes|integer|min:0|max:255',
            'lock_after_days' => 'sometimes|integer|min:0|max:255',
            'require_description' => 'sometimes|boolean',
            'min_description_length' => 'sometimes|integer|min:0|max:255',
            'allow_multiple_worklogs_per_session' => 'sometimes|boolean',
            'billable_tracking_enabled' => 'sometimes|boolean',
        ];
    }
}
