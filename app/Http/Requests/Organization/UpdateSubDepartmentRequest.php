<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['sometimes', 'string', 'max:150'],
            'description'    => ['nullable', 'string', 'max:500'],
            'head_user_uuid' => ['nullable', 'string', 'exists:users,uuid'],
            'is_active'      => ['nullable', 'boolean'],
        ];
    }
}
