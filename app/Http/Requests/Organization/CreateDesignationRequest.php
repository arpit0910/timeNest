<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class CreateDesignationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sub_department_uuid' => ['required', 'string', 'exists:sub_departments,uuid'],
            'name'                => ['required', 'string', 'max:150'],
            'description'         => ['nullable', 'string', 'max:500'],
            'level'               => ['required', 'integer', 'min:1', 'max:5'],
            'is_active'           => ['nullable', 'boolean'],
        ];
    }
}
