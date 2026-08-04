<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorklogPolicyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // worklog_mode/approval_flow aren't cast on this model (raw ints in
        // the DB — see App\Models\Attendance\WorklogPolicy vs the separately
        // cast App\Models\Worklog\WorklogPolicy), so resolve them manually,
        // the same pattern AttendanceDayResource uses for its own enums.
        $worklogMode = \App\Enums\Worklog\WorklogMode::tryFrom((int) $this->getRawOriginal('worklog_mode'));
        $approvalFlow = \App\Enums\Worklog\ApprovalFlow::tryFrom((int) $this->getRawOriginal('approval_flow'));

        return [
            'organization_uuid' => $this->organization?->uuid,
            'worklog_mode' => $worklogMode ? ['value' => $worklogMode->value, 'label' => $worklogMode->label()] : null,
            'approval_flow' => $approvalFlow ? ['value' => $approvalFlow->value, 'label' => $approvalFlow->label()] : null,
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
        ];
    }
}
