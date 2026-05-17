<?php

declare(strict_types=1);

namespace App\Http\Requests\Corporation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCorporationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorized by middleware
    }

    public function rules(): array
    {
        return [
            'legal_name' => ['sometimes', 'string', 'max:150'],
            'trading_name' => ['nullable', 'string', 'max:150'],
            'legal_entity_type' => ['nullable', 'string', 'max:50'],
            'industry' => ['nullable', 'string', 'max:100'],
            'company_size' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^\+[1-9][0-9]{6,14}$/'],
            'timezone' => ['sometimes', 'string', 'timezone:all'],
            'locale' => ['sometimes', 'string', 'max:10'],
            'currency_code' => ['sometimes', 'string', 'size:3'],
            'country_id' => ['nullable', 'exists:countries,id'],
        ];
    }
}
