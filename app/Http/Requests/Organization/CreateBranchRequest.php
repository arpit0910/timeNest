<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class CreateBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:20'],
            'is_headquarters' => ['nullable', 'boolean'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^\+[1-9][0-9]{6,14}$/'],
            'email' => ['nullable', 'email', 'max:191'],
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'state_uuid' => ['nullable', 'uuid', 'exists:states,uuid'],
            'country_uuid' => ['nullable', 'uuid', 'exists:countries,uuid'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'geo_fence_radius' => ['nullable', 'integer', 'min:0'],
            'timezone' => ['nullable', 'string', 'timezone:all'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
