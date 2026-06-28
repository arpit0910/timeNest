<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'        => $this->uuid,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'level'       => $this->level,
            'is_active'   => $this->is_active,
        ];
    }
}
