<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class EscalationListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|integer|in:1,2,3',
            'escalation_type' => 'nullable|integer|in:1,2,3,4,5,6',
            'user_uuid' => 'nullable|string|uuid|exists:users,uuid',
            'per_page' => 'nullable|integer|min:5|max:100',
        ];
    }
}
