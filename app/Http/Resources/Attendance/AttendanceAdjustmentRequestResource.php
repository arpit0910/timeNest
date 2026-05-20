<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceAdjustmentRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'attendance_day_id' => $this->attendance_day_id,
            'attendance_session_id' => $this->attendance_session_id,
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
