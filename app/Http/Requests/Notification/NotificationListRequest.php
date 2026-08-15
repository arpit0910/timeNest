<?php

declare(strict_types=1);

namespace App\Http\Requests\Notification;

use App\Enums\NotificationTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'category' => ['nullable', 'string', Rule::in(NotificationTypeEnum::categories())],
            'type' => ['nullable', 'string', Rule::in(NotificationTypeEnum::allValues())],
            // Omitted = both; true = unread only; false = read only.
            'unread' => ['nullable', 'boolean'],
            'priority' => ['nullable', 'integer', 'in:1,2,3'],
            'from' => ['nullable', 'date', 'date_format:Y-m-d'],
            'to' => ['nullable', 'date', 'date_format:Y-m-d'],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:100'],
        ];
    }
}
