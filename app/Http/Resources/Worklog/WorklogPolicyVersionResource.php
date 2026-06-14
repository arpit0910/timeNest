<?php

declare(strict_types=1);

namespace App\Http\Resources\Worklog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorklogPolicyVersionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->version,
            'worklog_policy_uuid' => $this->policy->uuid ?? null,
            'worklog_mode' => [
                'value' => $this->worklog_mode->value,
                'label' => $this->worklog_mode->label(),
                'description' => $this->worklog_mode->description(),
            ],
            'approval_flow' => [
                'value' => $this->approval_flow->value,
                'label' => $this->approval_flow->label(),
                'description' => $this->approval_flow->description(),
                'requires_approver' => $this->approval_flow->requiresApprover(),
                'requires_second_approver' => $this->approval_flow->requiresSecondApprover(),
            ],
            'require_worklog_on_clockout' => $this->require_worklog_on_clockout,
            'allow_deferred_submission' => $this->allow_deferred_submission,
            'submission_window_days' => $this->submission_window_days,
            'edit_grace_days' => $this->edit_grace_days,
            'lock_after_days' => $this->lock_after_days,
            'require_description' => $this->require_description,
            'min_description_length' => $this->min_description_length,
            'require_justification_on_overflow' => $this->require_justification_on_overflow,
            'require_project_mapping' => $this->require_project_mapping,
            'require_task_mapping' => $this->require_task_mapping,
            'allow_multiple_worklogs_per_session' => $this->allow_multiple_worklogs_per_session,
            'auto_escalate_overdue_logs' => $this->auto_escalate_overdue_logs,
            'billable_tracking_enabled' => $this->billable_tracking_enabled,
            'created_by_uuid' => $this->createdBy->uuid ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
