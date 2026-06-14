<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeavePolicyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'organization_uuid' => $this->organization->uuid ?? null,
            'approval_flow' => [
                'value' => $this->approval_flow->value,
                'label' => $this->approval_flow->label(),
                'description' => $this->approval_flow->description(),
                'requires_approver' => $this->approval_flow->requiresApprover(),
                'requires_second_approver' => $this->approval_flow->requiresSecondApprover(),
            ],
            'allow_half_day_leaves' => $this->allow_half_day_leaves,
            'allow_leave_on_weekends' => $this->allow_leave_on_weekends,
            'allow_leave_on_holidays' => $this->allow_leave_on_holidays,
            'advance_notice_required_days' => $this->advance_notice_required_days,
            'max_advance_application_days' => $this->max_advance_application_days,
            'document_required_after_days' => $this->document_required_after_days,
            'allow_leave_cancellation' => $this->allow_leave_cancellation,
            'cancellation_before_hours' => $this->cancellation_before_hours,
            'carry_forward_enabled' => $this->carry_forward_enabled,
            'max_carry_forward_days' => $this->max_carry_forward_days,
            'carry_forward_expiry_months' => $this->carry_forward_expiry_months,
            'accrual_enabled' => $this->accrual_enabled,
            'accrual_frequency' => $this->accrual_frequency ? [
                'value' => $this->accrual_frequency->value,
                'label' => $this->accrual_frequency->label(),
            ] : null,
            'negative_balance_allowed' => $this->negative_balance_allowed,
            'auto_approve_after_hours' => $this->auto_approve_after_hours,
            'current_version' => $this->versions->max('version'),
            'leave_types' => LeaveTypeResource::collection($this->whenLoaded('leaveTypes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
