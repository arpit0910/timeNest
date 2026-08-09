<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class ApproveLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled by LeaveRequestService::assertCanApprove()
        // (permission + hierarchy check against the resolved leave record) —
        // not duplicated here. This previously checked a 'leave.request.approve'
        // string that didn't exist anywhere as a real permission or Gate.
        return true;
    }

    public function rules(): array
    {
        return [
            'remarks' => 'nullable|string|max:500',
        ];
    }
}
