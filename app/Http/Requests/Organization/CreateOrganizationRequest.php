<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use App\Enums\OrganizationPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorized by middleware
    }

    public function rules(): array
    {
        return [
            'legal_name' => ['required', 'string', 'max:150'],
            'trading_name' => ['nullable', 'string', 'max:150'],
            'legal_entity_type' => ['nullable', 'string', 'max:50'],
            'industry' => ['nullable', 'string', 'max:100'],
            'company_size' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^\+[1-9][0-9]{6,14}$/'],
            'timezone' => ['nullable', 'string', 'timezone:all'],
            'locale' => ['nullable', 'string', 'max:10'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'plan' => ['nullable', new Enum(OrganizationPlan::class)],
            'max_users' => ['nullable', 'integer', 'min:1'],
            'country_uuid' => ['nullable', 'exists:countries,uuid'],

            // HQ Branch optional data
            'hq_name' => ['nullable', 'string', 'max:100'],
            'hq_code' => ['nullable', 'string', 'max:20'],
        ];
    }
}
