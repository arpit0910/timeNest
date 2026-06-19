<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceWorklogStatusRequest extends FormRequest
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
            'status' => 'required|integer',
            'remarks' => 'nullable|string',
            'metadata' => 'nullable|array',
        ];
    }
}
