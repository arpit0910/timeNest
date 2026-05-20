<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceDayResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'attendance_date' => $this->attendance_date->toDateString(),
            'attendance_status' => [
                'value' => $this->attendance_status?->value,
                'label' => $this->attendance_status?->label(),
                'color' => $this->attendance_status?->color(),
            ],
            'compliance_status' => [
                'value' => $this->compliance_status?->value,
                'label' => $this->compliance_status?->label(),
                'color' => $this->compliance_status?->color(),
            ],
            'total_work_minutes' => $this->total_work_minutes,
            'total_break_minutes' => $this->total_break_minutes,
            'total_sessions' => $this->total_sessions,
            'late_minutes' => $this->late_minutes,
            'overtime_minutes' => $this->overtime_minutes,
            'formatted_duration' => $this->formatted_duration,
            'sessions' => AttendanceSessionResource::collection($this->whenLoaded('attendanceSessions')),
        ];
    }
}
