<?php

declare(strict_types=1);

namespace App\Http\Requests\Corporation;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                 => ['required', 'string', 'max:100'],
            'code'                 => ['nullable', 'string', 'max:20'],
            'branch_id'            => ['nullable', 'exists:branches,id'],
            'parent_department_id' => ['nullable', 'exists:departments,id'],
            'head_user_id'         => ['nullable', 'exists:users,id'],
            'is_active'            => ['nullable', 'boolean'],
        ];
    }
}
