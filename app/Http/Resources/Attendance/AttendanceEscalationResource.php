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
            
            'uuid' => $this->uuid,
            'organization_uuid' => $this->organization?->uuid,
            'user_uuid' => $this->user?->uuid,
            'attendance_day_uuid' => $this->attendanceDay?->uuid,
            'attendance_worklog_uuid' => $this->attendanceWorklog?->uuid,
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
