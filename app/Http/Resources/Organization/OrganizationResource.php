<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'legal_name' => $this->legal_name,
            'trading_name' => $this->trading_name,
            'slug' => $this->slug,
            'legal_entity_type' => $this->legal_entity_type,
            'industry' => $this->industry,
            'company_size' => $this->company_size,
            'email' => $this->email,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'currency_code' => $this->currency_code,
            'logo_url' => $this->logo_url,
            'plan' => $this->plan,
            'max_users' => $this->max_users,
            'country_uuid' => $this->country?->uuid,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'verified_at' => $this->verified_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
