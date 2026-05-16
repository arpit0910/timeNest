<?php

declare(strict_types=1);

namespace App\Http\Requests\Corporation;

use Illuminate\Foundation\Http\FormRequest;

class AddMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'         => ['required', 'exists:users,id'],
            'role_id'         => ['required', 'exists:roles,id'],
            'employee_code'   => ['nullable', 'string', 'max:50'],
            'designation'     => ['nullable', 'string', 'max:100'],
            'department_id'   => ['nullable', 'exists:departments,id'],
            'branch_id'       => ['nullable', 'exists:branches,id'],
            'employment_type' => ['nullable', 'string', 'max:50'],
            'joining_date'    => ['nullable', 'date'],
            'reports_to'      => ['nullable', 'exists:users,id'],
        ];
    }
}
