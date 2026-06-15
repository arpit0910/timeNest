<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use App\Models\Worklog\WorklogPolicyVersion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorklogResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'attendance_day' => $this->whenLoaded('attendanceDay', function () {
                return [
                    'uuid' => $this->attendanceDay->uuid,
                    'attendance_date' => $this->attendanceDay->attendance_date,
                    'attendance_status' => $this->attendanceDay->attendance_status ? [
                        'value' => $this->attendanceDay->attendance_status->value,
                        'label' => $this->attendanceDay->attendance_status->label(),
                    ] : null,
                ];
            }),
            'attendance_session' => $this->whenLoaded('attendanceSession', function () {
                if (!$this->attendanceSession) {
                    return null;
                }
                return [
                    'uuid' => $this->attendanceSession->uuid,
                    'clock_in_at' => $this->attendanceSession->clock_in_at,
                    'clock_out_at' => $this->attendanceSession->clock_out_at,
                ];
            }),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'uuid' => $this->user->uuid,
                    'name' => $this->user->name,
                ];
            }),
            'submitted_by' => $this->whenLoaded('submittedBy', function () {
                return [
                    'uuid' => $this->submittedBy->uuid,
                    'name' => $this->submittedBy->name,
                ];
            }),
            'worklog_status' => $this->worklog_status ? [
                'value' => $this->worklog_status->value,
                'label' => $this->worklog_status->label(),
            ] : null,
            'compliance_status' => $this->compliance_status ? [
                'value' => $this->compliance_status->value,
                'label' => $this->compliance_status->label(),
            ] : null,
            'approval_flow' => $this->approval_flow_snapshot ? [
                'value' => $this->approval_flow_snapshot->value,
                'label' => $this->approval_flow_snapshot->label(),
            ] : null,
            'logged_minutes' => $this->logged_minutes,
            'description' => $this->description,
            'justification' => $this->justification,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'billable' => $this->billable,
            'project_id' => $this->project_id,
            'milestone_id' => $this->milestone_id,
            'task_id' => $this->task_id,
            'approved_by' => $this->whenLoaded('approvedBy', function () {
                if (!$this->approvedBy) return null;
                return [
                    'uuid' => $this->approvedBy->uuid,
                    'name' => $this->approvedBy->name,
                ];
            }),
            'approved_at' => $this->approved_at,
            'second_approver' => $this->whenLoaded('secondApprover', function () {
                if (!$this->secondApprover) return null;
                return [
                    'uuid' => $this->secondApprover->uuid,
                    'name' => $this->secondApprover->name,
                ];
            }),
            'second_approved_at' => $this->second_approved_at,
            'rejected_by' => $this->whenLoaded('rejectedBy', function () {
                if (!$this->rejectedBy) return null;
                return [
                    'uuid' => $this->rejectedBy->uuid,
                    'name' => $this->rejectedBy->name,
                ];
            }),
            'rejected_at' => $this->rejected_at,
            'rejection_reason' => $this->rejection_reason,
            'second_rejected_by' => $this->whenLoaded('secondRejectedBy', function () {
                if (!$this->secondRejectedBy) return null;
                return [
                    'uuid' => $this->secondRejectedBy->uuid,
                    'name' => $this->secondRejectedBy->name,
                ];
            }),
            'second_rejected_at' => $this->second_rejected_at,
            'has_first_level_approval' => $this->hasFirstLevelApproval(),
            'worklog_policy_version_id' => $this->whenLoaded('worklogPolicyVersion', function () {
                return $this->worklogPolicyVersion->version ?? null;
            }),
            'status_histories' => WorklogStatusHistoryResource::collection($this->whenLoaded('statusHistories')),
            'submitted_at' => $this->submitted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
