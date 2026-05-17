<?php

declare(strict_types=1);

namespace App\Http\Requests\Corporation;

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
        $corporationId = app()->bound('tenant.corporation')
            ? app('tenant.corporation')->id
            : null;

        return [
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:20'],
            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')->where('corporation_id', $corporationId),
            ],
            'parent_department_id' => [
                'nullable',
                Rule::exists('departments', 'id')->where('corporation_id', $corporationId),
            ],
            'head_user_id' => [
                'nullable',
                Rule::exists('corp_memberships', 'user_id')
                    ->where('corporation_id', $corporationId)
                    ->where('status', 'active'),
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
