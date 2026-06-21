<?php

declare(strict_types=1);

namespace App\Http\Requests\Leave;

use App\Enums\AccrualFrequencyEnum;
use App\Enums\ApprovalFlowEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateLeavePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('leave.policy.update');
    }

    public function rules(): array
    {
        return [
            'approval_flow' => ['sometimes', 'required', new Enum(ApprovalFlowEnum::class)],
            'allow_half_day_leaves' => 'sometimes|required|boolean',
            'allow_leave_on_weekends' => 'sometimes|required|boolean',
            'allow_leave_on_holidays' => 'sometimes|required|boolean',
            'advance_notice_required_days' => 'sometimes|required|integer|min:0|max:30',
            'max_advance_application_days' => 'sometimes|required|integer|min:1|max:365',
            'document_required_after_days' => 'sometimes|required|integer|min:1|max:30',
            'allow_leave_cancellation' => 'sometimes|required|boolean',
            'cancellation_before_hours' => 'sometimes|required|integer|min:0|max:720',
            'carry_forward_enabled' => 'sometimes|required|boolean',
            'max_carry_forward_days' => 'required_if:carry_forward_enabled,true|integer|min:0|max:365',
            'carry_forward_expiry_months' => 'required_if:carry_forward_enabled,true|integer|min:1|max:12',
            'accrual_enabled' => 'sometimes|required|boolean',
            'accrual_frequency' => ['required_if:accrual_enabled,true', new Enum(AccrualFrequencyEnum::class)],
            'negative_balance_allowed' => 'sometimes|required|boolean',
            'auto_approve_after_hours' => 'nullable|integer|min:1|max:720',
        ];
    }
}
