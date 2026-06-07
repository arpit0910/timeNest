<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\TwoFactor;

use Illuminate\Foundation\Http\FormRequest;

class InitiateSetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    protected function passedValidation(): void
    {
        if ($this->user()->two_factor_enabled_at !== null) {
            abort(422, 'Two-factor authentication is already enabled.');
        }
    }
}
