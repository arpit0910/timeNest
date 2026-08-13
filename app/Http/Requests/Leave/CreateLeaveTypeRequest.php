<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use App\Enums\Leave\LeaveType as LeaveTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateLeaveTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Handled by route 'permission:leave_policy.manage' middleware.
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            // Must be an App\Enums\Leave\LeaveType value as a string:
            // LeaveRequestService::submitLeave() resolves it via
            // LeaveTypeEnum::from((int) $leaveType->code). See
            // GET /api/v1/leave/type-codes for the selectable list.
            'code' => ['required', 'string', Rule::in(array_map(
                static fn (LeaveTypeEnum $case): string => (string) $case->value,
                LeaveTypeEnum::cases()
            ))],
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
