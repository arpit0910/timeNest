<?php

declare(strict_types=1);

namespace App\Http\Resources\Attendance;

use App\Enums\Attendance\AttendanceStatus;
use App\Enums\Attendance\ComplianceStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // Resolve enum instances from stored integer values
        $attendanceStatus = AttendanceStatus::tryFrom((int) $this->getRawOriginal('attendance_status'));
        $complianceStatus = ComplianceStatus::tryFrom((int) $this->getRawOriginal('compliance_status'));

        // Policy version info
        $policyVersion = $this->policyVersion;

        return [
            'uuid' => $this->uuid,
            'attendance_date' => $this->attendance_date?->format('Y-m-d'),
            'attendance_status' => $attendanceStatus ? [
                'value' => $attendanceStatus->value,
                'label' => $attendanceStatus->label(),
                'description' => $attendanceStatus->description(),
            ] : null,
            'compliance_status' => $complianceStatus ? [
                'value' => $complianceStatus->value,
                'label' => $complianceStatus->label(),
                'description' => $complianceStatus->description(),
            ] : null,
            'total_work_minutes' => $this->total_work_minutes,
            'total_break_minutes' => $this->total_break_minutes,
            'total_sessions' => $this->total_sessions,
            'late_minutes' => $this->late_minutes,
            'early_exit_minutes' => $this->early_exit_minutes,
            'overtime_minutes' => $this->overtime_minutes,
            'approved_by_uuid' => $this->whenLoaded('approvedBy', fn () => $this->approvedBy?->uuid),
            'approved_at' => $this->approved_at,
            'policy_version' => $policyVersion ? [
                'version_number' => $policyVersion->version,
                'approval_flow' => [
                    'value' => $policyVersion->approval_flow->value,
                    'label' => $policyVersion->approval_flow->label(),
                ],
            ] : null,
            'sessions' => AttendanceSessionResource::collection($this->whenLoaded('attendanceSessions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
