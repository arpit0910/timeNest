<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use App\Http\Resources\Concerns\ResolvesEmployeeCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceAdjustmentRequestResource extends JsonResource
{
    use ResolvesEmployeeCode;

    public function toArray(Request $request): array
    {
        return [
            
            'uuid' => $this->uuid,
            'user' => $this->whenLoaded('requestedBy', fn (): array => [
                'uuid' => $this->requestedBy->uuid,
                'name' => $this->requestedBy->name,
                'employee_code' => $this->employeeCodeFor($this->requestedBy, $this->attendanceDay?->organization_id),
                'avatar_url' => $this->requestedBy->avatar_url,
            ]),
            'attendance_day_uuid' => $this->attendanceDay?->uuid,
            'attendance_session_uuid' => $this->attendanceSession?->uuid,
            'adjustment_type' => [
                'value' => $this->adjustment_type?->value,
                'label' => $this->adjustment_type?->label(),
                'color' => $this->adjustment_type?->color(),
            ],
            'status' => [
                'value' => $this->status?->value,
                'label' => $this->status?->label(),
                'color' => $this->status?->color(),
            ],
            'details' => $this->details,
            'rejection_reason' => $this->rejection_reason,
            'resolved_at' => $this->resolved_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
