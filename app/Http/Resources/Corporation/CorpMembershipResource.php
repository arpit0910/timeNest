<?php

declare(strict_types=1);

namespace App\Http\Resources\Corporation;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorpMembershipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid'       => $this->uuid,
            'status'     => $this->status,
            'joined_at'  => $this->joined_at?->toISOString(),
            'role'       => $this->whenLoaded('user', function () {
                $role = $this->user->roles->first();
                return [
                    'name'        => $role?->name,
                    'description' => $role?->description,
                ];
            }),
            'user'       => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
