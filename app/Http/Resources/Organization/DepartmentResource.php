<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'code' => $this->code,
            'branch_uuid' => $this->branch?->uuid,
            'sub_departments' => SubDepartmentResource::collection(
                $this->whenLoaded('subDepartments')
            ),
            // The relation on Department is head(), not headUser() — under
            // Model::shouldBeStrict() the wrong name threw on every request.
            'head_user_uuid' => $this->whenLoaded('head', fn () => $this->head?->uuid),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
