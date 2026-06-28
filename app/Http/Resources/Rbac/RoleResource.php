<?php

declare(strict_types=1);

namespace App\Http\Resources\Rbac;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'           => $this->uuid,
            'name'           => $this->name,
            'guard_name'     => $this->guard_name,
            'is_system_role' => (bool) $this->is_system_role,
            'is_global'      => $this->organization_id === null,
            'sort_order'     => $this->sort_order,
            'permissions'    => $this->whenLoaded('permissions',
                fn() => $this->permissions->map(fn($p) => [
                    'name' => $p->name,
                ])->values()
            ),
            'created_at'     => $this->created_at?->toISOString(),
            'updated_at'     => $this->updated_at?->toISOString(),
        ];
    }
}
