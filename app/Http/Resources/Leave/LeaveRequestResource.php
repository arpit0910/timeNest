<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use App\Enums\Leave\ApprovalFlow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'organization_uuid' => $this->whenLoaded('organization', fn() => $this->organization->uuid),
            'user' => $this->whenLoaded('user', fn() => [
                'uuid' => $this->user->uuid,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]),
            'leave_type' => $this->whenLoaded('leaveType', fn() => [
                'uuid' => $this->leaveType->uuid,
                'name' => $this->leaveType->name,
                'code' => $this->leaveType->code,
                'color_hex' => $this->leaveType->color_hex,
                'is_paid' => $this->leaveType->is_paid,
            ]),
            'leave_status' => [
                'value' => $this->leave_status->value,
                'label' => $this->leave_status->label(),
            ],
            'approval_flow' => [
                'value' => $this->approval_flow_snapshot->value,
                'label' => $this->approval_flow_snapshot->name,
            ],
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'total_days' => (float) $this->total_days,
            'is_carry_forward' => (bool) $this->is_carry_forward,
            'reason' => $this->reason,
            'attachment_path' => $this->attachment_path,
            'approved_by' => $this->whenLoaded('approvedBy', fn() => [
                'uuid' => $this->approvedBy->uuid,
                'name' => $this->approvedBy->name,
            ]),
            'approved_at' => $this->approved_at?->toIso8601String(),
            'auto_approved_at' => $this->auto_approved_at?->toIso8601String(),
            'second_approver' => $this->whenLoaded('secondApprover', fn() => [
                'uuid' => $this->secondApprover->uuid,
                'name' => $this->secondApprover->name,
            ]),
            'second_approved_at' => $this->second_approved_at?->toIso8601String(),
            'rejected_by' => $this->whenLoaded('rejectedBy', fn() => [
                'uuid' => $this->rejectedBy->uuid,
                'name' => $this->rejectedBy->name,
            ]),
            'rejected_at' => $this->rejected_at?->toIso8601String(),
            'rejection_reason' => $this->cancellation_reason,
            'second_rejected_by' => $this->whenLoaded('secondRejectedBy', fn() => [
                'uuid' => $this->secondRejectedBy->uuid,
                'name' => $this->secondRejectedBy->name,
            ]),
            'second_rejected_at' => $this->second_rejected_at?->toIso8601String(),
            'cancellation_reason' => $this->cancellation_reason,
            'has_first_level_approval' => $this->hasFirstLevelApproval(),
            'status_histories' => LeaveStatusHistoryResource::collection($this->whenLoaded('statusHistories')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
