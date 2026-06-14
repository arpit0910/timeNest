<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'organization_uuid' => $this->organization->uuid ?? null,
            'leave_policy_uuid' => $this->policy->uuid ?? null,
            'name' => $this->name,
            'code' => $this->code,
            'color_hex' => $this->color_hex,
            'is_paid' => $this->is_paid,
            'is_system_type' => $this->is_system_type,
            'requires_document' => $this->requires_document,
            'allow_half_day' => $this->allow_half_day,
            'annual_allocation_days' => $this->annual_allocation_days,
            'max_per_request_days' => $this->max_per_request_days,
            'min_per_request_days' => $this->min_per_request_days,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
