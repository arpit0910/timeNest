<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Validates user registration data.
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'min:2', 'max:100'],
            'email'      => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'password'   => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'first_name' => ['nullable', 'string', 'max:60'],
            'last_name'  => ['nullable', 'string', 'max:60'],
            'phone'      => ['nullable', 'string', 'max:20', 'regex:/^\+[1-9][0-9]{6,14}$/'],
            'timezone'   => ['nullable', 'string', 'max:64', 'timezone:all'],
            'locale'     => ['nullable', 'string', 'max:10'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone number must be in E.164 format (e.g., +919876543210)',
        ];
    }
}
