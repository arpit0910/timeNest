<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceWorkDurationPenaltySlabResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'min_work_minutes' => $this->min_work_minutes,
            'max_work_minutes' => $this->max_work_minutes,
            'deduction_percentage' => $this->deduction_percentage,
        ];
    }
}
