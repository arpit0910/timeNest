<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceSessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'clock_in_at' => $this->clock_in_at?->toIso8601String(),
            'clock_out_at' => $this->clock_out_at?->toIso8601String(),
            'clock_in_ip' => $this->clock_in_ip,
            'clock_out_ip' => $this->clock_out_ip,
            'clock_in_source' => $this->clock_in_source?->label(),
            'clock_out_source' => $this->clock_out_source?->label(),
            'is_suspicious' => $this->is_suspicious,
            'suspicious_reason' => $this->suspicious_reason,
            'clock_in_latitude' => $this->clock_in_latitude,
            'clock_in_longitude' => $this->clock_in_longitude,
            'clock_out_latitude' => $this->clock_out_latitude,
            'clock_out_longitude' => $this->clock_out_longitude,
            'clock_in_accuracy' => $this->clock_in_accuracy,
            'clock_out_accuracy' => $this->clock_out_accuracy,
        ];
    }
}
