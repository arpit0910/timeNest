<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_code'   => ['sometimes', 'string', 'max:50'],
            'employment_type' => ['sometimes', 'string', 'in:full_time,part_time,contractor,intern,probation,consultant'],
            'joining_date'    => ['sometimes', 'date'],
            'confirmation_date' => ['sometimes', 'date'],
            'exit_date'       => ['sometimes', 'date'],
            'exit_reason'     => ['sometimes', 'string', 'max:255'],
            'work_location'   => ['sometimes', 'string', 'max:255'],
            'bio'             => ['sometimes', 'string'],
            'linkedin_url'    => ['sometimes', 'string', 'max:255'],
            'emergency_contact_name' => ['sometimes', 'string', 'max:100'],
            'emergency_contact_phone' => ['sometimes', 'string', 'max:20'],
            'emergency_contact_relation' => ['sometimes', 'string', 'max:50'],
            'branch_uuid'     => ['nullable', 'string', 'exists:branches,uuid'],
            'reports_to_uuid' => ['nullable', 'string', 'exists:users,uuid'],
            'department_uuid' => ['nullable', 'string', 'exists:departments,uuid'],
            'designation_uuid' => ['nullable', 'string', 'exists:designations,uuid'],
            'is_active'       => ['sometimes', 'boolean'],
            'documents'       => ['sometimes', 'array'],
        ];
    }
}
