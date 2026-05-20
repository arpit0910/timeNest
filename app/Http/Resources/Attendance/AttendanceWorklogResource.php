<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceWorklogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'corporation_id' => $this->corporation_id,
            'user_id' => $this->user_id,
            'attendance_day_id' => $this->attendance_day_id,
            'attendance_session_id' => $this->attendance_session_id,
            'project' => $this->project ? [
                'id' => $this->project->id,
                'uuid' => $this->project->uuid,
                'name' => $this->project->name,
            ] : null,
            'milestone' => $this->milestone ? [
                'id' => $this->milestone->id,
                'uuid' => $this->milestone->uuid,
                'name' => $this->milestone->name,
            ] : null,
            'task' => $this->task ? [
                'id' => $this->task->id,
                'uuid' => $this->task->uuid,
                'name' => $this->task->name,
                'estimated_minutes' => $this->task->estimated_minutes,
            ] : null,
            'worklog_status' => [
                'value' => $this->worklog_status?->value,
                'label' => $this->worklog_status?->label(),
                'color' => $this->worklog_status?->color(),
            ],
            'compliance_status' => [
                'value' => $this->compliance_status?->value,
                'label' => $this->compliance_status?->label(),
            ],
            'start_time' => $this->start_time?->toDateTimeString(),
            'end_time' => $this->end_time?->toDateTimeString(),
            'logged_minutes' => $this->logged_minutes,
            'description' => $this->description,
            'justification' => $this->justification,
            'submitted_at' => $this->submitted_at?->toDateTimeString(),
            'approved_at' => $this->approved_at?->toDateTimeString(),
            'rejected_at' => $this->rejected_at?->toDateTimeString(),
            'rejection_reason' => $this->rejection_reason,
            'metadata' => $this->metadata,
            'status_histories' => $this->statusHistories->map(fn($history) => [
                'old_status' => $history->old_status?->value,
                'new_status' => $history->new_status?->value,
                'remarks' => $history->remarks,
                'created_at' => $history->created_at?->toDateTimeString(),
            ]),
        ];
    }
}
