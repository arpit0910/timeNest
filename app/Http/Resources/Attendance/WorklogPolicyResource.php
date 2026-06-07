<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorklogPolicyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            
            'attendance_policy_uuid' => $this->attendancePolicy?->uuid,
            'require_worklog_on_clockout' => $this->require_worklog_on_clockout,
            'allow_deferred_submission' => $this->allow_deferred_submission,
            'require_project_mapping' => $this->require_project_mapping,
            'require_task_mapping' => $this->require_task_mapping,
            'require_justification_on_overflow' => $this->require_justification_on_overflow,
            'auto_escalate_overdue_logs' => $this->auto_escalate_overdue_logs,
            'overdue_after_days' => $this->overdue_after_days,
            'lock_after_days' => $this->lock_after_days,
            'allow_multiple_worklogs_per_session' => $this->allow_multiple_worklogs_per_session,
            'strict_mode_enabled' => $this->strict_mode_enabled,
            'flexible_mode_enabled' => $this->flexible_mode_enabled,
            'hybrid_mode_enabled' => $this->hybrid_mode_enabled,
        ];
    }
}
