<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveStatusHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'old_status' => [
                'value' => $this->old_status->value,
                'label' => $this->old_status->label(),
            ],
            'new_status' => [
                'value' => $this->new_status->value,
                'label' => $this->new_status->label(),
            ],
            'changed_by' => $this->whenLoaded('user', fn() => [
                'uuid' => $this->user->uuid,
                'name' => $this->user->name,
            ]),
            'remarks' => $this->remarks,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
