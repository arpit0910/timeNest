<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $organizationId = current_organization_id();

        return [
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:20'],
            'branch_uuid' => [
                'nullable',
                'uuid',
                Rule::exists('branches', 'uuid')->where('organization_id', $organizationId),
            ],
            'parent_department_uuid' => [
                'nullable',
                'uuid',
                Rule::exists('departments', 'uuid')->where('organization_id', $organizationId),
            ],
            'head_user_uuid' => [
                'nullable',
                'uuid',
                Rule::exists('users', 'uuid')
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
