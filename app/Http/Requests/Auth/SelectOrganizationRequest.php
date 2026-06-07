<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates organization selection/switching request.
 */
class SelectOrganizationRequest extends FormRequest
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
            'organization_uuid' => ['required', 'string', 'uuid'],
        ];
    }
}
