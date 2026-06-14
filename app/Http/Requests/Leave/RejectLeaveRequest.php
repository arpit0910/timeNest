<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class RejectLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave.request.approve');
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => 'required|string|min:5|max:500',
        ];
    }
}
