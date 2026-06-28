<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // authorization handled at route middleware level
    }

    public function rules(): array
    {
        return [
            'department_uuid' => ['required', 'string', 'exists:departments,uuid'],
            'name'            => ['required', 'string', 'max:150'],
            'description'     => ['nullable', 'string', 'max:500'],
            'head_user_uuid'  => ['nullable', 'string', 'exists:users,uuid'],
            'is_active'       => ['nullable', 'boolean'],
        ];
    }
}
