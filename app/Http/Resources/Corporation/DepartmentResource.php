<?php

declare(strict_types=1);

namespace App\Http\Resources\Corporation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid'                 => $this->uuid,
            'name'                 => $this->name,
            'code'                 => $this->code,
            'branch_id'            => $this->branch_id,
            'parent_department_id' => $this->parent_department_id,
            'head_user_id'         => $this->head_user_id,
            'is_active'            => $this->is_active,
            'created_at'           => $this->created_at?->toISOString(),
            'updated_at'           => $this->updated_at?->toISOString(),
        ];
    }
}
