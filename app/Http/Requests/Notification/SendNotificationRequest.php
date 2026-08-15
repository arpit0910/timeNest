<?php

declare(strict_types=1);

namespace App\Http\Requests\Notification;

use App\Enums\NotificationTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Admin-raised notification. Either a broadcast to the whole organization
 * (`notifications.send`) or a targeted send to named recipients
 * (`notifications.manage`) — the controller checks which applies.
 */
class SendNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'body' => ['nullable', 'string', 'max:2000'],
            'type' => ['nullable', 'string', Rule::in(NotificationTypeEnum::allValues())],
            'priority' => ['nullable', 'integer', 'in:1,2,3'],
            'action_url' => ['nullable', 'string', 'max:255'],
            // Omit to broadcast to every member of the active organization.
            'user_uuids' => ['nullable', 'array', 'min:1'],
            'user_uuids.*' => ['required', 'uuid', 'exists:users,uuid'],
        ];
    }
}
