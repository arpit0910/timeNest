<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use App\Enums\EscalationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttendanceEscalationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled by route 'permission:' middleware +
        // $this->authorize() in the controller — not duplicated here.
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'integer', Rule::in([EscalationStatusEnum::RESOLVED->value, EscalationStatusEnum::DISMISSED->value])],
            'remarks' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'The status must be either 2 (Resolved) or 3 (Dismissed).',
        ];
    }
}
