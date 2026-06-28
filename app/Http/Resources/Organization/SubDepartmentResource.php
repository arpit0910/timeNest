<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Resources\Json\JsonResource;

class SubDepartmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'            => $this->uuid,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'description'     => $this->description,
            'is_active'       => $this->is_active,
            'is_global'       => $this->organization_id === null,
            'department'      => $this->whenLoaded('department', fn() => [
                'uuid' => $this->department->uuid,
                'name' => $this->department->name,
            ]),
            'head'            => $this->whenLoaded('head', fn() => [
                'uuid' => $this->head?->uuid,
                'name' => $this->head?->name,
            ]),
            'designations'    => DesignationResource::collection(
                $this->whenLoaded('designations')
            ),
            'created_at'      => $this->created_at?->toISOString(),
            'updated_at'      => $this->updated_at?->toISOString(),
        ];
    }
}
