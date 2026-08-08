<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class WorklogListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_uuid' => 'nullable|string|uuid|exists:users,uuid',
            'status' => 'nullable|integer|in:1,2,3,4,5,6',
            'from' => 'nullable|date|date_format:Y-m-d',
            'to' => 'nullable|date|date_format:Y-m-d',
            'per_page' => 'nullable|integer|min:5|max:100',
        ];
    }
}
