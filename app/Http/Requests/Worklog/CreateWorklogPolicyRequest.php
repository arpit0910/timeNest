<?php

declare(strict_types=1);

namespace App\Http\Requests\Worklog;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorklogPolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('worklog.policy.create');
    }

    public function rules(): array
    {
        return [
            'worklog_mode' => 'required|integer|in:1,2,3',
            'approval_flow' => 'required|integer|in:1,2,3',
            'require_worklog_on_clockout' => 'required|boolean',
            'allow_deferred_submission' => 'required|boolean',
            'submission_window_days' => 'required|integer|min:1|max:30',
            'edit_grace_days' => 'required|integer|min:0|max:30',
            'lock_after_days' => 'required|integer|min:1|max:90',
            'require_description' => 'required|boolean',
            'min_description_length' => 'required_if:require_description,true|integer|min:0|max:500',
            'require_justification_on_overflow' => 'required|boolean',
            'require_project_mapping' => 'required|boolean',
            'require_task_mapping' => 'required|boolean',
            'allow_multiple_worklogs_per_session' => 'required|boolean',
            'auto_escalate_overdue_logs' => 'required|boolean',
            'billable_tracking_enabled' => 'required|boolean',
        ];
    }
}
