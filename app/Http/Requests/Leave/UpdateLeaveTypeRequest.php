<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave.type.update');
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:100',
            'code' => 'sometimes|required|string|max:50|alpha_dash',
            'color_hex' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_paid' => 'sometimes|required|boolean',
            'requires_document' => 'sometimes|required|boolean',
            'allow_half_day' => 'sometimes|required|boolean',
            'annual_allocation_days' => 'sometimes|required|numeric|min:0.5|max:365',
            'max_per_request_days' => 'nullable|integer|min:1|max:365',
            'min_per_request_days' => 'sometimes|required|numeric|min:0.5|max:30',
            'is_active' => 'sometimes|required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:255',
        ];
    }
}
