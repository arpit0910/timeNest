<?php

declare(strict_types=1);

namespace App\Http\Requests\Rbac;

use Illuminate\Foundation\Http\FormRequest;

class CreateGlobalRoleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:100'],
            'is_system_role' => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer', 'min:1', 'max:999'],
        ];
    }
}
