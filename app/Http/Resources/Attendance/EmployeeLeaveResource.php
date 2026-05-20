<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLeaveResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'leave_type' => [
                'value' => $this->leave_type?->value,
                'label' => $this->leave_type?->label(),
                'color' => $this->leave_type?->color(),
            ],
            'leave_status' => [
                'value' => $this->leave_status?->value,
                'label' => $this->leave_status?->label(),
                'color' => $this->leave_status?->color(),
            ],
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'total_days' => (float) $this->total_days,
            'reason' => $this->reason,
            'attachment_path' => $this->attachment_path,
            'cancellation_reason' => $this->cancellation_reason,
            'approved_at' => $this->approved_at?->toIso8601String(),
            'rejected_at' => $this->rejected_at?->toIso8601String(),
        ];
    }
}
