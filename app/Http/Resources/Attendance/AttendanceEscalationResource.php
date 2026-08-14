<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use App\Http\Resources\Concerns\ResolvesEmployeeCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceEscalationResource extends JsonResource
{
    use ResolvesEmployeeCode;

    public function toArray(Request $request): array
    {
        return [
            
            'uuid' => $this->uuid,
            'organization_uuid' => $this->organization?->uuid,
            'user_uuid' => $this->user?->uuid,
            'user' => $this->whenLoaded('user', fn (): array => [
                'uuid' => $this->user->uuid,
                'name' => $this->user->name,
                'employee_code' => $this->employeeCodeFor($this->user, $this->organization_id),
                'avatar_url' => $this->user->avatar_url,
            ]),
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
