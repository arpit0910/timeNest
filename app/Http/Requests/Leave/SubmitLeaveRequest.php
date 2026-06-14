<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class SubmitLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave.request.create');
    }

    public function rules(): array
    {
        return [
            'leave_type_id' => 'required|string|uuid',
            'start_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
            'reason' => 'required|string|min:10|max:1000',
            'is_half_day' => 'nullable|boolean',
            'attachment_path' => 'nullable|string|max:500',
        ];
    }
}
