<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class RejectLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled by LeaveRequestService::assertCanApprove()
        // (permission + hierarchy check against the resolved leave record).
        return true;
    }

    public function rules(): array
    {
        return [
            'rejection_reason' => 'required|string|min:5|max:500',
        ];
    }
}
