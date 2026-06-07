<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use App\Enums\EmploymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AddMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $organizationId = current_organization_id();

        return [
            'user_uuid' => ['required', 'exists:users,uuid'],
            'role_uuid' => [
                'required',
                'uuid',
                Rule::exists('roles', 'uuid')->where(function ($query) use ($organizationId): void {
                    $query->whereNull('organization_id')
                        ->orWhere('organization_id', $organizationId);
                }),
            ],
            'employee_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('employee_profiles', 'employee_code')->where('organization_id', $organizationId),
            ],
            'designation' => ['nullable', 'string', 'max:100'],
            'department_uuid' => [
                'nullable',
                'uuid',
                Rule::exists('departments', 'uuid')->where('organization_id', $organizationId),
            ],
            'branch_uuid' => [
                'nullable',
                'uuid',
                Rule::exists('branches', 'uuid')->where('organization_id', $organizationId),
            ],
            'employment_type' => ['nullable', new Enum(EmploymentType::class)],
            'joining_date' => ['nullable', 'date'],
            'reports_to_uuid' => [
                'nullable',
                'uuid',
                Rule::exists('users', 'uuid')
            ],
        ];
    }
}
