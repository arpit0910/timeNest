<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use App\Enums\AttendanceAdjustmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_day_uuid' => ['required', 'exists:attendance_days,uuid'],
            'attendance_session_uuid' => ['nullable', 'uuid', 'exists:attendance_sessions,uuid'],
            'adjustment_type' => ['required', new Enum(AttendanceAdjustmentTypeEnum::class)],
            'clock_in_at' => ['nullable', 'date'],
            'clock_out_at' => ['nullable', 'date', 'after_or_equal:clock_in_at'],
            'reason' => ['required', 'string', 'max:500'],
        ];
    }
}
