<?php

declare(strict_types=1);

namespace App\Http\Requests\Corporation;

use App\Enums\CorporationPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateCorporationRequest extends FormRequest
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
            'plan' => ['nullable', new Enum(CorporationPlan::class)],
            'max_users' => ['nullable', 'integer', 'min:1'],
            'country_id' => ['nullable', 'exists:countries,id'],

            // HQ Branch optional data
            'hq_name' => ['nullable', 'string', 'max:100'],
            'hq_code' => ['nullable', 'string', 'max:20'],
        ];
    }
}
