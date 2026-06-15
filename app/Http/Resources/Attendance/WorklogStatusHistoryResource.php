<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorklogStatusHistoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'old_status' => $this->old_status ? [
                'value' => $this->old_status->value,
                'label' => $this->old_status->label(),
            ] : null,
            'new_status' => $this->new_status ? [
                'value' => $this->new_status->value,
                'label' => $this->new_status->label(),
            ] : null,
            'changed_by' => $this->whenLoaded('changedBy', function () {
                return [
                    'uuid' => $this->changedBy->uuid,
                    'name' => $this->changedBy->name,
                ];
            }),
            'remarks' => $this->remarks,
            'created_at' => $this->created_at,
        ];
    }
}
