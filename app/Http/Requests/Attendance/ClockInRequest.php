<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use App\Enums\AttendanceSessionSourceEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ClockInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'clock_in_source' => ['required', 'integer', new Enum(AttendanceSessionSourceEnum::class)],
            'clock_in_ip' => 'nullable|ip',
            'clock_in_device_id' => 'nullable|string|max:255',
            'clock_in_latitude' => 'nullable|numeric|between:-90,90',
            'clock_in_longitude' => 'nullable|numeric|between:-180,180',
            'clock_in_accuracy' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'clock_in_source.required' => 'The clock-in source is required.',
            'clock_in_source.in' => 'Invalid clock-in source. Must be 1 (Mobile), 2 (Web), 3 (Admin), or 4 (System).',
            'clock_in_ip.ip' => 'The clock-in IP address must be a valid IP.',
            'clock_in_device_id.max' => 'The device ID must not exceed 255 characters.',
            'clock_in_latitude.between' => 'Latitude must be between -90 and 90.',
            'clock_in_longitude.between' => 'Longitude must be between -180 and 180.',
            'clock_in_accuracy.min' => 'Accuracy must be a non-negative number.',
        ];
    }
}
