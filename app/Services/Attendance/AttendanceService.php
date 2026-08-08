<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Enums\Attendance\AttendanceMode;
use App\Enums\AttendanceAdjustmentStatusEnum;
use App\Enums\AttendanceAdjustmentTypeEnum;
use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\AttendanceSessionSourceEnum;
use App\Enums\AttendanceStatusEnum;
use App\Enums\Leave\LeaveStatus;
use App\Enums\Leave\LeaveType as LeaveTypeEnum;
use App\Enums\SystemPermission;
use App\Exceptions\Business\AuthorizationException;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Exceptions\Leave\LeaveAttendanceConflictException;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceActivityLog;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Attendance\AttendanceSession;
use App\Models\Auth\User;
use App\Models\Leave\EmployeeLeave;
use App\Models\Organization\Organization;
use App\Models\Membership\EmployeeProfile;
use App\Policies\Concerns\ResolvesApprovalHierarchy;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceService
{
    use ResolvesApprovalHierarchy;

    public function __construct(
        private readonly GeofenceService $geofenceService,
        private readonly AttendancePolicyService $policyService,
        private readonly LeaveManagementService $leaveManagementService,
        private readonly AttendanceCalculationService $calculationService,
    ) {}

    /**
     * The calendar date (Y-m-d) "today" resolves to for this user, in their
     * branch/user timezone rather than the app's own (UTC) — shared by
     * clockOut() and AttendanceController::today() so a day boundary is
     * drawn consistently everywhere it's checked.
     */
    public function resolveTodayDate(User $user, Organization $organization): string
    {
        $profile = EmployeeProfile::where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->with('branch')
            ->first();

        $timezone = $profile?->branch?->timezone ?? $user->timezone ?? 'UTC';

        return now($timezone)->toDateString();
    }

    /**
     * Clock-In Employee.
     */
    public function clockIn(User $user, Organization $organization, array $data): AttendanceSession
    {
        return DB::transaction(function () use ($user, $organization, $data) {
            // Fetch profile for branch timezone & branch assignment
            $profile = EmployeeProfile::where('user_id', $user->id)
                ->where('organization_id', $organization->id)
                ->with('branch')
                ->first();

            if (! $profile) {
                throw new BusinessRuleViolationException('Employee profile not found.', 'PROFILE_NOT_FOUND');
            }

            $timezone = $profile->branch?->timezone ?? $user->timezone ?? 'UTC';
            // Resolved in this timezone, not the app's own (UTC) — otherwise a
            // clock-in between midnight and (UTC offset) AM local time gets
            // filed under the previous UTC calendar day instead of today.
            $todayDate = now($timezone)->toDateString();

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
                'attendance_status' => AttendanceStatusEnum::INCOMPLETE->value,
                'compliance_status' => AttendanceComplianceStatusEnum::PENDING->value,
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

            if (! $isWFH && $policy->geo_fencing_enabled) {
                $latitude = $data['latitude'] ?? null;
                $longitude = $data['longitude'] ?? null;
                $accuracy = (float) ($data['accuracy'] ?? 0);
                $attendanceMode = $policy->attendance_mode;

                if ($latitude === null || $longitude === null) {
                    // No coordinates provided
                    if ($attendanceMode === AttendanceMode::STRICT) {
                        throw new BusinessRuleViolationException(
                            'Location is required for clock-in under strict attendance mode.',
                            'LOCATION_REQUIRED'
                        );
                    }
                    // Flexible/Hybrid: allow but flag suspicious
                    $isSuspicious = true;
                    $suspiciousReason = 'Location not provided but geo-fencing is enabled.';
                } else {
                    try {
                        $this->geofenceService->validateAndFindBranch(
                            $organization,
                            (float) $latitude,
                            (float) $longitude,
                            $accuracy
                        );
                    } catch (BusinessRuleViolationException $e) {
                        if ($attendanceMode === AttendanceMode::STRICT) {
                            // Strict mode: hard block — do not allow clock-in outside geofence
                            throw $e;
                        }

                        // Flexible/Hybrid: allow clock-in but flag as suspicious
                        $isSuspicious = true;
                        $suspiciousReason = $e->getMessage();
                    }
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
                'clock_in_source' => $data['source'] ?? AttendanceSessionSourceEnum::WEB->value,
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
            $todayDate = $this->resolveTodayDate($user, $organization);

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

            // Geofence check on clock-out (flag only, never block)
            $isSuspicious = (bool) $session->is_suspicious;
            $suspiciousReason = $session->suspicious_reason;

            $policy = $this->policyService->getPolicy($organization);
            $isWFH = $this->leaveManagementService->hasApprovedWFH($user->id, $todayDate);

            if (! $isWFH && $policy && $policy->geo_fencing_enabled) {
                $latitude = $data['latitude'] ?? null;
                $longitude = $data['longitude'] ?? null;
                $accuracy = (float) ($data['accuracy'] ?? 0);

                if ($latitude === null || $longitude === null) {
                    $isSuspicious = true;
                    $clockOutReason = 'Clock-out location not provided but geo-fencing is enabled.';
                    $suspiciousReason = $suspiciousReason
                        ? $suspiciousReason . ' | ' . $clockOutReason
                        : $clockOutReason;
                } else {
                    try {
                        $this->geofenceService->validateAndFindBranch(
                            $organization,
                            (float) $latitude,
                            (float) $longitude,
                            $accuracy
                        );
                    } catch (BusinessRuleViolationException $e) {
                        $isSuspicious = true;
                        $clockOutReason = 'Clock-out: ' . $e->getMessage();
                        $suspiciousReason = $suspiciousReason
                            ? $suspiciousReason . ' | ' . $clockOutReason
                            : $clockOutReason;
                    }
                }
            }

            // Update session clock-out details
            $session->update([
                'clock_out_at' => now(),
                'clock_out_ip' => $data['ip_address'] ?? null,
                'clock_out_device_id' => $data['device_id'] ?? null,
                'clock_out_accuracy' => $data['accuracy'] ?? null,
                'clock_out_latitude' => $data['latitude'] ?? null,
                'clock_out_longitude' => $data['longitude'] ?? null,
                'clock_out_source' => $data['source'] ?? AttendanceSessionSourceEnum::WEB->value,
                'is_suspicious' => $isSuspicious,
                'suspicious_reason' => $suspiciousReason,
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
        // Reverse check: Block adjustment submission if an approved leave exists for the target date (excluding WFH / EWD)
        $hasApprovedLeave = EmployeeLeave::where('user_id', $day->user_id)
            ->whereNotIn('leave_type', [
                LeaveTypeEnum::WORK_FROM_HOME->value,
                LeaveTypeEnum::EXTRA_WORKING_DAY->value,
            ])
            ->whereIn('leave_status', [LeaveStatus::APPROVED->value, LeaveStatus::AUTO_APPROVED->value])
            ->where('start_date', '<=', $day->attendance_date)
            ->where('end_date', '>=', $day->attendance_date)
            ->exists();

        if ($hasApprovedLeave) {
            throw new LeaveAttendanceConflictException("Cannot submit attendance adjustment: an approved leave request exists for date {$day->attendance_date}.");
        }

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
                'status' => AttendanceAdjustmentStatusEnum::PENDING->value,
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
                case AttendanceAdjustmentTypeEnum::CLOCK_IN_CORRECTION:
                    if (! $session) {
                        throw new BusinessRuleViolationException('Session is required for clock-in correction.', 'SESSION_REQUIRED');
                    }
                    $session->update(['clock_in_at' => Carbon::parse($details['clock_in_at'])]);
                    break;

                case AttendanceAdjustmentTypeEnum::CLOCK_OUT_CORRECTION:
                    if (! $session) {
                        throw new BusinessRuleViolationException('Session is required for clock-out correction.', 'SESSION_REQUIRED');
                    }
                    $session->update(['clock_out_at' => Carbon::parse($details['clock_out_at'])]);
                    break;

                case AttendanceAdjustmentTypeEnum::SESSION_DELETION:
                    if (! $session) {
                        throw new BusinessRuleViolationException('Session is required for deletion.', 'SESSION_REQUIRED');
                    }
                    $session->delete();
                    break;

                case AttendanceAdjustmentTypeEnum::MANUAL_ATTENDANCE:
                    $day->attendanceSessions()->create([
                        'clock_in_at' => Carbon::parse($details['clock_in_at']),
                        'clock_out_at' => $details['clock_out_at'] ? Carbon::parse($details['clock_out_at']) : null,
                        'clock_in_source' => AttendanceSessionSourceEnum::ADMIN_PANEL->value,
                        'clock_out_source' => $details['clock_out_at'] ? AttendanceSessionSourceEnum::ADMIN_PANEL->value : null,
                    ]);
                    break;
            }

            // Update adjustment request status
            $request->update([
                'status' => AttendanceAdjustmentStatusEnum::APPROVED->value,
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
                'status' => AttendanceAdjustmentStatusEnum::REJECTED->value,
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
     * Get paginated attendance history for a user (or targeted user if authorized).
     */
    public function getHistory(User $authUser, Organization $organization, array $filters): LengthAwarePaginator
    {
        setPermissionsTeamId($organization->id);

        try {
            $userUuid = $filters['user_uuid'] ?? null;
            $targetUser = $authUser;

            if ($userUuid !== null) {
                $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                if (! $this->canViewUser($authUser, $targetUser->id, $organization->id, SystemPermission::ATTENDANCE_VIEW)) {
                    throw new AuthorizationException('You are not authorized to view attendance for this user.', 'CANNOT_VIEW_USER_ATTENDANCE');
                }
            }

            $query = AttendanceDay::where('organization_id', $organization->id)
                ->where('user_id', $targetUser->id)
                ->with(['user.employeeProfiles' => fn ($q) => $q->where('organization_id', $organization->id), 'attendanceSessions', 'policyVersion']);

            $startDate = $filters['start_date'] ?? $filters['from'] ?? null;
            $endDate = $filters['end_date'] ?? $filters['to'] ?? null;

            if ($startDate !== null) {
                $query->where('attendance_date', '>=', $startDate);
            }
            if ($endDate !== null) {
                $query->where('attendance_date', '<=', $endDate);
            }
            if (isset($filters['status'])) {
                $query->where('attendance_status', (int) $filters['status']);
            }

            $perPage = (int) ($filters['per_page'] ?? 30);

            return $query->orderBy('attendance_date', 'desc')->paginate($perPage);
        } finally {
            setPermissionsTeamId(null);
        }
    }

    /**
     * Get today's attendance summary for a user (or targeted user if authorized).
     */
    public function getToday(User $authUser, Organization $organization, ?string $userUuid = null): ?AttendanceDay
    {
        setPermissionsTeamId($organization->id);

        try {
            $targetUser = $authUser;

            if ($userUuid !== null) {
                $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                if (! $this->canViewUser($authUser, $targetUser->id, $organization->id, SystemPermission::ATTENDANCE_VIEW)) {
                    throw new AuthorizationException('You are not authorized to view attendance for this user.', 'CANNOT_VIEW_USER_ATTENDANCE');
                }
            }

            $today = $this->resolveTodayDate($targetUser, $organization);

            return AttendanceDay::where('organization_id', $organization->id)
                ->where('user_id', $targetUser->id)
                ->where('attendance_date', $today)
                ->with(['user.employeeProfiles' => fn ($q) => $q->where('organization_id', $organization->id), 'attendanceSessions', 'policyVersion'])
                ->first();
        } finally {
            setPermissionsTeamId(null);
        }
    }

    /**
     * Get paginated adjustment requests with hierarchy scoping and filtering.
     */
    public function getAdjustments(User $requester, Organization $organization, array $filters): LengthAwarePaginator
    {
        setPermissionsTeamId($organization->id);

        try {
            $canApproveAny = $requester->hasPermissionTo(SystemPermission::ATTENDANCE_APPROVE_ANY->value)
                || $requester->hasPermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value);
            $canApprove = $requester->hasPermissionTo(SystemPermission::ATTENDANCE_APPROVE->value);

            $query = AttendanceAdjustmentRequest::whereHas('attendanceDay', function ($q) use ($organization) {
                $q->where('organization_id', $organization->id);
            })->with(['attendanceDay.user.employeeProfiles', 'attendanceSession', 'requestedBy', 'resolvedBy']);

            $userUuid = $filters['user_uuid'] ?? null;

            if ($canApproveAny) {
                if ($userUuid !== null) {
                    $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                    $query->where('requested_by', $targetUser->id);
                }
            } elseif ($canApprove) {
                $subordinateUserIds = $this->getSubordinateUserIds($requester, $organization->id);
                $allowedUserIds = array_merge([$requester->id], $subordinateUserIds);

                if ($userUuid !== null) {
                    $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                    if (! in_array($targetUser->id, $allowedUserIds, true)) {
                        throw new AuthorizationException('You are not authorized to view adjustments for this user.', 'CANNOT_VIEW_USER_ATTENDANCE');
                    }
                    $query->where('requested_by', $targetUser->id);
                } else {
                    $query->whereIn('requested_by', $allowedUserIds);
                }
            } else {
                if ($userUuid !== null) {
                    $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                    if ($targetUser->id !== $requester->id) {
                        throw new AuthorizationException('Insufficient scope to view adjustments for other users.', 'INSUFFICIENT_SCOPE');
                    }
                }
                $query->where('requested_by', $requester->id);
            }

            if (isset($filters['status'])) {
                $query->where('status', (int) $filters['status']);
            }

            if (isset($filters['adjustment_type'])) {
                $query->where('adjustment_type', (int) $filters['adjustment_type']);
            }

            $startDate = $filters['start_date'] ?? $filters['from'] ?? null;
            $endDate = $filters['end_date'] ?? $filters['to'] ?? null;

            if ($startDate !== null || $endDate !== null) {
                $query->whereHas('attendanceDay', function ($q) use ($startDate, $endDate) {
                    if ($startDate !== null) {
                        $q->where('attendance_date', '>=', $startDate);
                    }
                    if ($endDate !== null) {
                        $q->where('attendance_date', '<=', $endDate);
                    }
                });
            }

            $perPage = (int) ($filters['per_page'] ?? 30);

            return $query->orderBy('created_at', 'desc')->paginate($perPage);
        } finally {
            setPermissionsTeamId(null);
        }
    }

    /**
     * Get paginated escalations with hierarchy scoping and filtering.
     */
    public function getEscalations(User $requester, Organization $organization, array $filters): LengthAwarePaginator
    {
        setPermissionsTeamId($organization->id);

        try {
            $canResolve = $requester->hasPermissionTo(SystemPermission::ATTENDANCE_ESCALATIONS_RESOLVE->value)
                || $requester->hasPermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value);
            $canView = $requester->hasPermissionTo(SystemPermission::ATTENDANCE_ESCALATIONS_VIEW->value);

            $query = AttendanceEscalation::where('organization_id', $organization->id)
                ->with(['user.employeeProfiles', 'attendanceDay', 'attendanceWorklog', 'resolvedBy']);

            $userUuid = $filters['user_uuid'] ?? null;

            if ($canResolve) {
                if ($userUuid !== null) {
                    $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                    $query->where('user_id', $targetUser->id);
                }
            } elseif ($canView) {
                $subordinateUserIds = $this->getSubordinateUserIds($requester, $organization->id);
                $allowedUserIds = array_merge([$requester->id], $subordinateUserIds);

                if ($userUuid !== null) {
                    $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                    if (! in_array($targetUser->id, $allowedUserIds, true)) {
                        throw new AuthorizationException('You are not authorized to view escalations for this user.', 'CANNOT_VIEW_USER_ATTENDANCE');
                    }
                    $query->where('user_id', $targetUser->id);
                } else {
                    $query->whereIn('user_id', $allowedUserIds);
                }
            } else {
                if ($userUuid !== null) {
                    $targetUser = User::where('uuid', $userUuid)->firstOrFail();
                    if ($targetUser->id !== $requester->id) {
                        throw new AuthorizationException('Insufficient scope to view escalations for other users.', 'INSUFFICIENT_SCOPE');
                    }
                }
                $query->where('user_id', $requester->id);
            }

            if (isset($filters['status'])) {
                $query->where('escalation_status', (int) $filters['status']);
            }

            if (isset($filters['escalation_type'])) {
                $query->where('escalation_type', (int) $filters['escalation_type']);
            }

            $perPage = (int) ($filters['per_page'] ?? 30);

            return $query->orderBy('created_at', 'desc')->paginate($perPage);
        } finally {
            setPermissionsTeamId(null);
        }
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
