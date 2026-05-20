<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceEscalationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'corporation_id' => $this->corporation_id,
            'user_id' => $this->user_id,
            'attendance_day_id' => $this->attendance_day_id,
            'attendance_worklog_id' => $this->attendance_worklog_id,
            'escalation_type' => [
                'value' => $this->escalation_type?->value,
                'label' => $this->escalation_type?->label(),
            ],
            'escalation_level' => $this->escalation_level,
            'escalation_status' => [
                'value' => $this->escalation_status?->value,
                'label' => $this->escalation_status?->label(),
            ],
            'remarks' => $this->remarks,
            'metadata' => $this->metadata,
            'resolved_by' => $this->resolved_by,
            'resolved_at' => $this->resolved_at?->toDateTimeString(),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
