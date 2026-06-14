<?php

declare(strict_types=1);

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class ClockOutRequest extends FormRequest
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
            'clock_out_source' => 'required|integer|in:1,2,3,4',
            'clock_out_ip' => 'nullable|ip',
            'clock_out_device_id' => 'nullable|string|max:255',
            'clock_out_latitude' => 'nullable|numeric|between:-90,90',
            'clock_out_longitude' => 'nullable|numeric|between:-180,180',
            'clock_out_accuracy' => 'nullable|numeric|min:0',
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
            'clock_out_source.required' => 'The clock-out source is required.',
            'clock_out_source.in' => 'Invalid clock-out source. Must be 1 (Mobile), 2 (Web), 3 (Admin), or 4 (System).',
            'clock_out_ip.ip' => 'The clock-out IP address must be a valid IP.',
            'clock_out_device_id.max' => 'The device ID must not exceed 255 characters.',
            'clock_out_latitude.between' => 'Latitude must be between -90 and 90.',
            'clock_out_longitude.between' => 'Longitude must be between -180 and 180.',
            'clock_out_accuracy.min' => 'Accuracy must be a non-negative number.',
        ];
    }
}
