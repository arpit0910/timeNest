<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lightweight organization summary used in auth responses (login,
 * select-organization, me) — deliberately a smaller subset than the full
 * OrganizationResource (no industry/plan/billing fields), shared so the
 * shape stays identical across all three endpoints.
 */
class OrganizationSummaryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'legal_name' => $this->legal_name,
            'trading_name' => $this->trading_name,
            'slug' => $this->slug,
            'logo_url' => $this->logo_url,
            'type' => $this->type?->value,
            'type_label' => $this->type?->label(),
        ];
    }
}
