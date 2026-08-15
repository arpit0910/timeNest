<?php

declare(strict_types=1);

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'type' => $this->type?->value,
            'category' => $this->category,
            'priority' => $this->priority?->value,
            'priority_label' => $this->priority?->label(),
            'title' => $this->title,
            'body' => $this->body,
            // Deep link the mobile client pushes on tap, e.g. "/leave/{uuid}".
            'action_url' => $this->action_url,
            'data' => $this->data,
            'is_read' => $this->read_at !== null,
            'read_at' => $this->read_at?->toISOString(),
            'actor' => $this->whenLoaded('actor', fn () => $this->actor ? [
                'uuid' => $this->actor->uuid,
                'name' => $this->actor->name,
                'avatar_url' => $this->actor->avatar_url,
            ] : null),
            'organization_uuid' => $this->whenLoaded('organization', fn () => $this->organization?->uuid),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
