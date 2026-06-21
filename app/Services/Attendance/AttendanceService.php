<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\AttendanceAdjustmentStatusEnum;
use App\Enums\AttendanceAdjustmentTypeEnum;
use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\AttendanceSessionSourceEnum;
use App\Enums\AttendanceStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceActivityLog;
use App\Models\Attendance\AttendanceSession;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Membership\EmployeeProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceService
{
    public function __construct(
        private readonly GeofenceService $geofenceService,
        private readonly AttendancePolicyService $policyService,
        private readonly LeaveManagementService $leaveManagementService,
        private readonly AttendanceCalculationService $calculationService,
    ) {}

    /**
     * Clock-In Employee.
     */
    public function clockIn(User $user, Organization $organization, array $data): AttendanceSession
    {
        return DB::transaction(function () use ($user, $organization, $data) {
            $todayDate = now()->toDateString();

            // Fetch profile for branch timezone & branch assignment
            $profile = EmployeeProfile::where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->with('branch')
                ->first();

            if (! $profile) {
                throw new BusinessRuleViolationException('Employee profile not found.', 'PROFILE_NOT_FOUND');
            }

            $timezone = $profile->branch?->timezone ?? $user->timezone ?? 'UTC';

            // Get policy
            $policy = $this->policyService->getPolicy($organization);
            if (! $policy) {
                throw new BusinessRuleViolationException('No attendance policy configured for this organization.', 'NO_POLICY_CONFIGURED');
            }

            // Create or get daily attendance record
            $day = AttendanceDay::firstOrCreate([
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'attendance_date' => $todayDate,
            ], [
                'attendance_status' => AttendanceStatusEnum::Incomplete->value,
                'compliance_status' => AttendanceComplianceStatusEnum::Pending->value,
            ]);

            // Track active policy version snapshot on first clock-in of the day
            if (! $day->attendance_policy_version_id) {
                $latestVersion = $policy->versions()->orderBy('version', 'desc')->first();
                if ($latestVersion) {
                    $day->update(['attendance_policy_version_id' => $latestVersion->id]);
                }
            }

            // 1. Verify there is no active session currently running
            $activeSession = $day->attendanceSessions()->whereNull('clock_out_at')->first();
            if ($activeSession) {
                throw new BusinessRuleViolationException('You already have an active clock-in session.', 'ACTIVE_SESSION_EXISTS');
            }

            // 2. Check if multiple sessions are allowed
            if (! $policy->allow_multiple_sessions && $day->attendanceSessions()->exists()) {
                throw new BusinessRuleViolationException('Multiple clock-in sessions are not allowed by your company policy.', 'MULTIPLE_SESSIONS_BLOCKED');
            }

            // 3. Holiday and Weekend Rules
            $isHoliday = $this->calculationService->isHoliday($organization->id, $profile->branch_id, $todayDate);
            $isWeekend = $this->calculationService->isWeekend($todayDate, $timezone, $policy->weekend_days ?? []);
            $hasEWD = $this->leaveManagementService->hasApprovedEWD($user->id, $todayDate);

            if ($isHoliday) {
                if (! $policy->allow_clock_in_on_holidays && ! $hasEWD) {
                    throw new BusinessRuleViolationException('Clock-in blocked on holidays.', 'HOLIDAY_CLOCK_IN_BLOCKED');
                }
            }

            if ($isWeekend) {
                if (! $hasEWD) {
                    throw new BusinessRuleViolationException('Clock-in blocked on weekends.', 'WEEKEND_CLOCK_IN_BLOCKED');
                }
            }

            // 4. Leave Check (standard leaves block clock-in)
            $hasLeave = $this->leaveManagementService->hasApprovedLeave($user->id, $todayDate);
            if ($hasLeave) {
                throw new BusinessRuleViolationException('Clock-in blocked because you are on approved leave.', 'LEAVE_ACTIVE_CLOCK_IN_BLOCKED');
            }

            // 5. Geofence validation (bypassed if WFH is active)
            $isWFH = $this->leaveManagementService->hasApprovedWFH($user->id, $todayDate);
            $isSuspicious = false;
            $suspiciousReason = null;

            if (! $isWFH) {
                $latitude = (float) ($data['latitude'] ?? 0);
                $longitude = (float) ($data['longitude'] ?? 0);
                $accuracy = (float) ($data['accuracy'] ?? 0);

                try {
                    $this->geofenceService->validateAndFindBranch($organization, $latitude, $longitude, $accuracy);
                } catch (BusinessRuleViolationException $e) {
                    // Let's check if the policy allows hybrid/flexible clock-in with warning or blocks.
                    // For Phase 1, we block if they are outside geofence.
                    throw $e;
                }
            }

            // Create session
            $session = $day->attendanceSessions()->create([
                'clock_in_at' => now(),
                'clock_in_ip' => $data['ip_address'] ?? null,
                'clock_in_device_id' => $data['device_id'] ?? null,
                'clock_in_accuracy' => $data['accuracy'] ?? null,
                'clock_in_latitude' => $data['latitude'] ?? null,
                'clock_in_longitude' => $data['longitude'] ?? null,
                'clock_in_source' => $data['source'] ?? AttendanceSessionSourceEnum::Web->value,
                'is_suspicious' => $isSuspicious,
                'suspicious_reason' => $suspiciousReason,
            ]);

            // Update daily calculations
            $this->calculationService->recalculateDay($day);

            // Audit Trail Log
            $this->logActivity($organization->id, $user->id, $user->id, 'clock_in', null, $session->toArray());

            return $session;
        });
    }

    /**
     * Clock-Out Employee.
     */
    public function clockOut(User $user, Organization $organization, array $data): AttendanceSession
    {
        return DB::transaction(function () use ($user, $organization, $data) {
            $todayDate = now()->toDateString();

            // Find current AttendanceDay
            $day = AttendanceDay::where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->where('attendance_date', $todayDate)
                ->first();

            if (! $day) {
                throw new BusinessRuleViolationException('No active clock-in session found for today.', 'NO_CLOCK_IN_RECORD');
            }

            // Find active session
            $session = $day->attendanceSessions()->whereNull('clock_out_at')->first();
            if (! $session) {
                throw new BusinessRuleViolationException('No active clock-in session found.', 'NO_ACTIVE_SESSION');
            }

            $oldSessionValues = $session->toArray();

            // Update session clock-out details
            $session->update([
                'clock_out_at' => now(),
                'clock_out_ip' => $data['ip_address'] ?? null,
                'clock_out_device_id' => $data['device_id'] ?? null,
                'clock_out_accuracy' => $data['accuracy'] ?? null,
                'clock_out_latitude' => $data['latitude'] ?? null,
                'clock_out_longitude' => $data['longitude'] ?? null,
                'clock_out_source' => $data['source'] ?? AttendanceSessionSourceEnum::Web->value,
            ]);

            // Update daily calculations
            $this->calculationService->recalculateDay($day);

            // Audit Trail Log
            $this->logActivity($organization->id, $user->id, $user->id, 'clock_out', $oldSessionValues, $session->fresh()->toArray());

            return $session;
        });
    }

    /**
     * Submit an attendance adjustment request.
     */
    public function submitAdjustment(User $user, AttendanceDay $day, array $data): AttendanceAdjustmentRequest
    {
        return DB::transaction(function () use ($user, $day, $data) {
            $sessionUuid = $data['attendance_session_uuid'] ?? null;
            $sessionId = null;
            $type = AttendanceAdjustmentTypeEnum::from((int) $data['adjustment_type']);

            // Validate session belongs to day if provided
            if ($sessionUuid) {
                $sessionExists = AttendanceSession::where('uuid', $sessionUuid)
                    ->where('attendance_day_id', $day->id)
                    ->first();
                if (! $sessionExists) {
                    throw new BusinessRuleViolationException('The session does not belong to the selected attendance day.', 'INVALID_SESSION_DAY');
                }
                $sessionId = $sessionExists->id;
            }

            return AttendanceAdjustmentRequest::create([
                'attendance_day_id' => $day->id,
                'attendance_session_id' => $sessionId,
                'requested_by' => $user->id,
                'adjustment_type' => $type->value,
                'status' => AttendanceAdjustmentStatusEnum::Pending->value,
                'details' => [
                    'clock_in_at' => $data['clock_in_at'] ?? null,
                    'clock_out_at' => $data['clock_out_at'] ?? null,
                    'reason' => $data['reason'],
                ],
            ]);
        });
    }

    /**
     * Approve adjustment request and apply changes.
     */
    public function approveAdjustment(AttendanceAdjustmentRequest $request, User $resolver): AttendanceAdjustmentRequest
    {
        if (! $request->isPending()) {
            throw new BusinessRuleViolationException('This adjustment request has already been processed.', 'ADJUSTMENT_ALREADY_PROCESSED');
        }

        return DB::transaction(function () use ($request, $resolver) {
            $day = $request->attendanceDay;
            $session = $request->attendanceSession;
            $type = $request->adjustment_type;
            $details = $request->details;

            $oldDayValues = $day->toArray();

            // Perform corrections depending on type
            switch ($type) {
                case AttendanceAdjustmentTypeEnum::ClockInCorrection:
                    if (! $session) {
                        throw new BusinessRuleViolationException('Session is required for clock-in correction.', 'SESSION_REQUIRED');
                    }
                    $session->update(['clock_in_at' => Carbon::parse($details['clock_in_at'])]);
                    break;

                case AttendanceAdjustmentTypeEnum::ClockOutCorrection:
                    if (! $session) {
                        throw new BusinessRuleViolationException('Session is required for clock-out correction.', 'SESSION_REQUIRED');
                    }
                    $session->update(['clock_out_at' => Carbon::parse($details['clock_out_at'])]);
                    break;

                case AttendanceAdjustmentTypeEnum::SessionDeletion:
                    if (! $session) {
                        throw new BusinessRuleViolationException('Session is required for deletion.', 'SESSION_REQUIRED');
                    }
                    $session->delete();
                    break;

                case AttendanceAdjustmentTypeEnum::ManualAttendance:
                    $day->attendanceSessions()->create([
                        'clock_in_at' => Carbon::parse($details['clock_in_at']),
                        'clock_out_at' => $details['clock_out_at'] ? Carbon::parse($details['clock_out_at']) : null,
                        'clock_in_source' => AttendanceSessionSourceEnum::AdminPanel->value,
                        'clock_out_source' => $details['clock_out_at'] ? AttendanceSessionSourceEnum::AdminPanel->value : null,
                    ]);
                    break;
            }

            // Update adjustment request status
            $request->update([
                'status' => AttendanceAdjustmentStatusEnum::Approved->value,
                'resolved_by' => $resolver->id,
                'resolved_at' => now(),
            ]);

            // Recalculate day aggregates
            $this->calculationService->recalculateDay($day);

            // Audit activity log
            $this->logActivity($day->organization_id, $day->user_id, $resolver->id, 'adjustment_approved', $oldDayValues, $day->fresh()->toArray());

            return $request;
        });
    }

    /**
     * Reject adjustment request.
     */
    public function rejectAdjustment(AttendanceAdjustmentRequest $request, User $resolver, string $reason): AttendanceAdjustmentRequest
    {
        if (! $request->isPending()) {
            throw new BusinessRuleViolationException('This adjustment request has already been processed.', 'ADJUSTMENT_ALREADY_PROCESSED');
        }

        return DB::transaction(function () use ($request, $resolver, $reason) {
            $request->update([
                'status' => AttendanceAdjustmentStatusEnum::Rejected->value,
                //TODO: Need rejected at time too
                'resolved_by' => $resolver->id,
                'resolved_at' => now(),
                'rejection_reason' => $reason,
            ]);

            // Audit activity log
            $day = $request->attendanceDay;
            $this->logActivity($day->organization_id, $day->user_id, $resolver->id, 'adjustment_rejected', null, $request->toArray());

            return $request;
        });
    }

    /**
     * Create an activity/audit log entry.
     */
    private function logActivity(int $organizationId, int $userId, int $actorId, string $action, ?array $old, ?array $new): void
    {
        // TODO: Fifure out the actual usecase of this, if no usecase then remove this.
        AttendanceActivityLog::create([
            'organization_id' => $organizationId,
            'user_id' => $userId,
            'actor_id' => $actorId,
            'action' => $action,
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
