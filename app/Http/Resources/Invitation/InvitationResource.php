<?php

declare(strict_types=1);

namespace App\Http\Resources\Invitation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'expires_at' => $this->expires_at?->toISOString(),
            'accepted_at' => $this->accepted_at?->toISOString(),
            'revoked_at' => $this->revoked_at?->toISOString(),
            'resend_count' => $this->resend_count,
            'last_resent_at' => $this->last_resent_at?->toISOString(),
            'metadata' => $this->metadata,
            'role' => [
                'uuid' => $this->role?->uuid,
                'name' => $this->role?->name,
                'description' => $this->role?->description,
            ],
            'invited_by' => [
                'uuid' => $this->invitedBy?->uuid,
                'name' => $this->invitedBy?->name,
                'email' => $this->invitedBy?->email,
            ],
            'revoked_by' => $this->revokedBy ? [
                'uuid' => $this->revokedBy->uuid,
                'name' => $this->revokedBy->name,
            ] : null,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
