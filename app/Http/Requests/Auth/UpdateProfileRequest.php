<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates self-service updates to the authenticated user's own identity
 * fields. Deliberately excludes email/password (separate, more sensitive
 * flows) and anything employment-related (EmployeeProfileController, which
 * requires the employee_profile.manage permission — this endpoint needs no
 * elevated permission since a user is always allowed to edit their own
 * identity).
 */
class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:191'],
            'first_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'last_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'timezone' => ['sometimes', 'string', 'timezone'],
            'locale' => ['sometimes', 'string', 'max:10'],
            'avatar_url' => ['sometimes', 'nullable', 'string', 'url', 'max:500'],
        ];
    }
}
