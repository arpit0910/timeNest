<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'            => $this->uuid,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'description'     => $this->description,
            'level'           => $this->level,
            'level_label'     => match($this->level) {
                1 => 'Junior',
                2 => 'Mid',
                3 => 'Senior',
                4 => 'Lead',
                5 => 'Principal / Head',
                default => 'Unknown',
            },
            'is_active'       => $this->is_active,
            'is_global'       => $this->organization_id === null,
            'sub_department'  => $this->whenLoaded('subDepartment', fn() => [
                'uuid' => $this->subDepartment->uuid,
                'name' => $this->subDepartment->name,
                'department' => $this->subDepartment->relationLoaded('department') ? [
                    'uuid' => $this->subDepartment->department->uuid,
                    'name' => $this->subDepartment->department->name,
                ] : null,
            ]),
            'created_at'      => $this->created_at?->toISOString(),
            'updated_at'      => $this->updated_at?->toISOString(),
        ];
    }
}
