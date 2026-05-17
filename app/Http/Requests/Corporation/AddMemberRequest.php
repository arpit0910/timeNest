<?php

declare(strict_types=1);

namespace App\Http\Requests\Corporation;

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
        $corporationId = tenant_corporation()?->id;

        return [
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => [
                'required',
                Rule::exists('roles', 'id')->where(function ($query) use ($corporationId): void {
                    $query->whereNull('corporation_id')
                        ->orWhere('corporation_id', $corporationId);
                }),
            ],
            'employee_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('employee_profiles', 'employee_code')->where('corporation_id', $corporationId),
            ],
            'designation' => ['nullable', 'string', 'max:100'],
            'department_id' => [
                'nullable',
                Rule::exists('departments', 'id')->where('corporation_id', $corporationId),
            ],
            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')->where('corporation_id', $corporationId),
            ],
            'employment_type' => ['nullable', new Enum(EmploymentType::class)],
            'joining_date' => ['nullable', 'date'],
            'reports_to' => [
                'nullable',
                Rule::exists('corp_memberships', 'user_id')
                    ->where('corporation_id', $corporationId)
                    ->where('status', 'active'),
            ],
        ];
    }
}
