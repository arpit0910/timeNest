<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use App\Enums\Attendance\ClockSource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $clockInSource = $this->clock_in_source;
        $clockOutSource = $this->clock_out_source;

        // Compute duration in minutes
        $durationMinutes = null;
        if ($this->clock_out_at !== null) {
            $durationMinutes = (int) floor(
                $this->clock_out_at->diffInSeconds($this->clock_in_at) / 60
            );
        }

        return [
            'uuid' => $this->uuid,
            'clock_in_at' => $this->clock_in_at,
            'clock_out_at' => $this->clock_out_at,
            'clock_in_source' => $clockInSource ? [
                'value' => $clockInSource->value,
                'label' => $clockInSource->label(),
            ] : null,
            'clock_out_source' => $clockOutSource ? [
                'value' => $clockOutSource->value,
                'label' => $clockOutSource->label(),
            ] : null,
            'clock_in_latitude' => $this->clock_in_latitude,
            'clock_in_longitude' => $this->clock_in_longitude,
            'clock_out_latitude' => $this->clock_out_latitude,
            'clock_out_longitude' => $this->clock_out_longitude,
            'is_suspicious' => $this->is_suspicious,
            'suspicious_reason' => $this->suspicious_reason,
            'duration_minutes' => $durationMinutes,
        ];
    }
}
