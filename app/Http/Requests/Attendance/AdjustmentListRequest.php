<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class AdjustmentListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|integer|in:1,2,3,4',
            'adjustment_type' => 'nullable|integer|in:1,2,3,4',
            'user_uuid' => 'nullable|string|uuid|exists:users,uuid',
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'from' => 'nullable|date|date_format:Y-m-d',
            'end_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
            'to' => 'nullable|date|date_format:Y-m-d|after_or_equal:from',
            'per_page' => 'nullable|integer|min:5|max:100',
        ];
    }
}
