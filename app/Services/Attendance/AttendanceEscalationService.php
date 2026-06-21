<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\EscalationStatusEnum;
use App\Enums\EscalationTypeEnum;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceEscalationService
{
    /**
     * Trigger/Create a new escalation.
     */
    public function triggerEscalation(
        int $organizationId,
        int $userId,
        EscalationTypeEnum $type,
        ?int $dayId = null,
        ?int $worklogId = null,
        ?string $remarks = null,
        array $metadata = []
    ): AttendanceEscalation {
        return DB::transaction(function () use ($organizationId, $userId, $type, $dayId, $worklogId, $remarks, $metadata) {
            // Check if there is an active pending escalation of this type for this worklog/day
            $existing = AttendanceEscalation::where('user_id', $userId)
                ->where('escalation_type', $type->value)
                ->where('escalation_status', EscalationStatusEnum::PENDING->value);

            if ($worklogId) {
                $existing->where('attendance_worklog_id', $worklogId);
            } elseif ($dayId) {
                $existing->where('attendance_day_id', $dayId);
            }

            $escalation = $existing->first();

            if ($escalation) {
                // If it already exists, increment level
                $escalation->increment('escalation_level');
                $escalation->update([
                    'remarks' => $remarks ?? $escalation->remarks,
                    'metadata' => array_merge($escalation->metadata ?? [], $metadata),
                ]);
                return $escalation;
            }

            return AttendanceEscalation::create([
                'organization_id' => $organizationId,
                'user_id' => $userId,
                'attendance_day_id' => $dayId,
                'attendance_worklog_id' => $worklogId,
                'escalation_type' => $type->value,
                'escalation_level' => 1,
                'escalation_status' => EscalationStatusEnum::PENDING->value,
                'remarks' => $remarks,
                'metadata' => $metadata,
            ]);
        });
    }

    /**
     * Resolve an escalation.
     */
    public function resolveEscalation(AttendanceEscalation $escalation, User $resolvedBy, ?string $remarks = null): AttendanceEscalation
    {
        return DB::transaction(function () use ($escalation, $resolvedBy, $remarks) {
            $escalation->update([
                'escalation_status' => EscalationStatusEnum::RESOLVED->value,
                'resolved_by' => $resolvedBy->id,
                'resolved_at' => now(),
                'remarks' => $remarks ?: $escalation->remarks,
            ]);

            return $escalation;
        });
    }

    /**
     * Dismiss an escalation.
     */
    public function dismissEscalation(AttendanceEscalation $escalation, User $resolvedBy, ?string $remarks = null): AttendanceEscalation
    {
        return DB::transaction(function () use ($escalation, $resolvedBy, $remarks) {
            $escalation->update([
                'escalation_status' => EscalationStatusEnum::DISMISSED->value,
                'resolved_by' => $resolvedBy->id,
                'resolved_at' => now(),
                'remarks' => $remarks ?: $escalation->remarks,
            ]);

            return $escalation;
        });
    }
}
