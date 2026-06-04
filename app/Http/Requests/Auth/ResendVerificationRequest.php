<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates the resend verification email request.
 *
 * Only requires a valid email format — existence is NOT validated
 * to prevent user enumeration attacks.
 */
class ResendVerificationRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:191'],
        ];
    }
}
