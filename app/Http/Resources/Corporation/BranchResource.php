<?php

declare(strict_types=1);

namespace App\Http\Resources\Corporation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid'            => $this->uuid,
            'name'            => $this->name,
            'code'            => $this->code,
            'is_headquarters' => $this->is_headquarters,
            'phone'           => $this->phone,
            'email'           => $this->email,
            'address_line_1'  => $this->address_line_1,
            'address_line_2'  => $this->address_line_2,
            'city'            => $this->city,
            'postal_code'     => $this->postal_code,
            'state_id'        => $this->state_id,
            'country_id'      => $this->country_id,
            'latitude'        => $this->latitude,
            'longitude'       => $this->longitude,
            'geo_fence_radius'=> $this->geo_fence_radius,
            'timezone'        => $this->timezone,
            'is_active'       => $this->is_active,
            'created_at'      => $this->created_at?->toISOString(),
            'updated_at'      => $this->updated_at?->toISOString(),
        ];
    }
}
