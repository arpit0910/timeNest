<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeaveTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave.type.create');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|alpha_dash',
            'color_hex' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_paid' => 'required|boolean',
            'requires_document' => 'required|boolean',
            'allow_half_day' => 'required|boolean',
            'annual_allocation_days' => 'required|numeric|min:0.5|max:365',
            'max_per_request_days' => 'nullable|integer|min:1|max:365',
            'min_per_request_days' => 'required|numeric|min:0.5|max:30',
            'is_active' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:255',
        ];
    }
}
