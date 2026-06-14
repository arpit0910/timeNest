<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveBalanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'leave_type' => $this->whenLoaded('leaveType', fn() => [
                'uuid' => $this->leaveType->uuid,
                'name' => $this->leaveType->name,
                'code' => $this->leaveType->code,
                'color_hex' => $this->leaveType->color_hex,
            ]),
            'year' => $this->year,
            'allocated_days' => (float) $this->allocated_days,
            'carry_forward_days' => (float) $this->carry_forward_days,
            'used_days' => (float) $this->used_days,
            'pending_days' => (float) $this->pending_days,
            'remaining_days' => (float) $this->remaining_days,
        ];
    }
}
