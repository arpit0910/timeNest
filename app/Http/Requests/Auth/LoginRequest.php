<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates login credentials.
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email', 'max:191'],
            'password' => ['required', 'string', 'min:8', 'max:128'],
        ];
    }
}
