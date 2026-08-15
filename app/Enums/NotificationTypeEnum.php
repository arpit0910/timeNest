<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Every in-app notification the platform can raise.
 *
 * Values are stable strings (not ints) because the mobile client keys its
 * icon/route mapping off them — renumbering would silently repoint deep links.
 * Grouped by the module that triggers them.
 */
enum NotificationTypeEnum: string
{
    // ─── Attendance ──────────────────────────────────────────────
    case ATTENDANCE_INCOMPLETE = 'attendance.incomplete';
    case ATTENDANCE_MISSING_CLOCK_OUT = 'attendance.missing_clock_out';
    case ATTENDANCE_LATE_ARRIVAL = 'attendance.late_arrival';
    case ATTENDANCE_ADJUSTMENT_REQUESTED = 'attendance.adjustment_requested';
    case ATTENDANCE_ADJUSTMENT_APPROVED = 'attendance.adjustment_approved';
    case ATTENDANCE_ADJUSTMENT_REJECTED = 'attendance.adjustment_rejected';
    case ATTENDANCE_ESCALATION_RAISED = 'attendance.escalation_raised';
    case ATTENDANCE_ESCALATION_RESOLVED = 'attendance.escalation_resolved';

    // ─── Worklogs ────────────────────────────────────────────────
    case WORKLOG_SUBMITTED = 'worklog.submitted';
    case WORKLOG_APPROVED = 'worklog.approved';
    case WORKLOG_REJECTED = 'worklog.rejected';
    case WORKLOG_DUE = 'worklog.due';

    // ─── Leave ───────────────────────────────────────────────────
    case LEAVE_SUBMITTED = 'leave.submitted';
    case LEAVE_APPROVED = 'leave.approved';
    case LEAVE_REJECTED = 'leave.rejected';
    case LEAVE_CANCELLED = 'leave.cancelled';
    case LEAVE_PENDING_APPROVAL = 'leave.pending_approval';

    // ─── Account & security ──────────────────────────────────────
    case AUTH_NEW_LOGIN = 'auth.new_login';
    case AUTH_PASSWORD_CHANGED = 'auth.password_changed';
    case AUTH_TWO_FACTOR_ENABLED = 'auth.two_factor_enabled';
    case AUTH_TWO_FACTOR_DISABLED = 'auth.two_factor_disabled';
    case PROFILE_UPDATED = 'profile.updated';
    case EMPLOYEE_PROFILE_UPDATED = 'employee_profile.updated';

    // ─── Membership & RBAC ───────────────────────────────────────
    case MEMBER_ADDED = 'member.added';
    case MEMBER_REMOVED = 'member.removed';
    case ROLE_ASSIGNED = 'role.assigned';
    case ROLE_PERMISSIONS_CHANGED = 'role.permissions_changed';
    case DESIGNATION_ASSIGNED = 'designation.assigned';
    case DEPARTMENT_HEAD_ASSIGNED = 'department.head_assigned';
    case SUB_DEPARTMENT_HEAD_ASSIGNED = 'sub_department.head_assigned';

    // ─── Invitations ─────────────────────────────────────────────
    case INVITATION_RECEIVED = 'invitation.received';
    case INVITATION_ACCEPTED = 'invitation.accepted';
    case INVITATION_REVOKED = 'invitation.revoked';

    // ─── Policy ──────────────────────────────────────────────────
    case POLICY_UPDATED = 'policy.updated';

    // ─── Generic ─────────────────────────────────────────────────
    case ANNOUNCEMENT = 'announcement';

    /**
     * The module segment, used to group and filter notification lists.
     */
    public function category(): string
    {
        return str_contains($this->value, '.') ? explode('.', $this->value)[0] : 'general';
    }

    /**
     * Default human-readable title. Callers may override per notification when
     * they can say something more specific ("Priya approved your leave").
     */
    public function defaultTitle(): string
    {
        return match ($this) {
            self::ATTENDANCE_INCOMPLETE => 'Incomplete attendance',
            self::ATTENDANCE_MISSING_CLOCK_OUT => 'Missing clock-out',
            self::ATTENDANCE_LATE_ARRIVAL => 'Late arrival recorded',
            self::ATTENDANCE_ADJUSTMENT_REQUESTED => 'Attendance adjustment requested',
            self::ATTENDANCE_ADJUSTMENT_APPROVED => 'Attendance adjustment approved',
            self::ATTENDANCE_ADJUSTMENT_REJECTED => 'Attendance adjustment rejected',
            self::ATTENDANCE_ESCALATION_RAISED => 'Attendance escalation raised',
            self::ATTENDANCE_ESCALATION_RESOLVED => 'Attendance escalation resolved',
            self::WORKLOG_SUBMITTED => 'Worklog submitted for approval',
            self::WORKLOG_APPROVED => 'Worklog approved',
            self::WORKLOG_REJECTED => 'Worklog rejected',
            self::WORKLOG_DUE => 'Worklog due',
            self::LEAVE_SUBMITTED => 'Leave request submitted',
            self::LEAVE_APPROVED => 'Leave approved',
            self::LEAVE_REJECTED => 'Leave rejected',
            self::LEAVE_CANCELLED => 'Leave cancelled',
            self::LEAVE_PENDING_APPROVAL => 'Leave request awaiting your approval',
            self::AUTH_NEW_LOGIN => 'New sign-in to your account',
            self::AUTH_PASSWORD_CHANGED => 'Password changed',
            self::AUTH_TWO_FACTOR_ENABLED => 'Two-factor authentication enabled',
            self::AUTH_TWO_FACTOR_DISABLED => 'Two-factor authentication disabled',
            self::PROFILE_UPDATED => 'Profile updated',
            self::EMPLOYEE_PROFILE_UPDATED => 'Employee profile updated',
            self::MEMBER_ADDED => 'Added to organization',
            self::MEMBER_REMOVED => 'Removed from organization',
            self::ROLE_ASSIGNED => 'Role updated',
            self::ROLE_PERMISSIONS_CHANGED => 'Role permissions changed',
            self::DESIGNATION_ASSIGNED => 'Designation updated',
            self::DEPARTMENT_HEAD_ASSIGNED => 'Department head assigned',
            self::SUB_DEPARTMENT_HEAD_ASSIGNED => 'Sub-department head assigned',
            self::INVITATION_RECEIVED => 'You have been invited',
            self::INVITATION_ACCEPTED => 'Invitation accepted',
            self::INVITATION_REVOKED => 'Invitation revoked',
            self::POLICY_UPDATED => 'Policy updated',
            self::ANNOUNCEMENT => 'Announcement',
        };
    }

    /**
     * Security and approval events are worth interrupting for; routine
     * confirmations are not. Drives ordering and the client's badge treatment.
     */
    public function defaultPriority(): NotificationPriorityEnum
    {
        return match ($this) {
            self::AUTH_NEW_LOGIN,
            self::AUTH_PASSWORD_CHANGED,
            self::AUTH_TWO_FACTOR_DISABLED,
            self::ATTENDANCE_ESCALATION_RAISED,
            self::MEMBER_REMOVED => NotificationPriorityEnum::HIGH,

            self::LEAVE_PENDING_APPROVAL,
            self::WORKLOG_SUBMITTED,
            self::ATTENDANCE_ADJUSTMENT_REQUESTED,
            self::ATTENDANCE_INCOMPLETE,
            self::ATTENDANCE_MISSING_CLOCK_OUT,
            self::WORKLOG_DUE,
            self::LEAVE_APPROVED,
            self::LEAVE_REJECTED,
            self::ROLE_ASSIGNED => NotificationPriorityEnum::NORMAL,

            default => NotificationPriorityEnum::LOW,
        };
    }

    /**
     * @return string[]
     */
    public static function allValues(): array
    {
        return array_map(fn (self $c) => $c->value, self::cases());
    }

    /**
     * Distinct category segments, for the client's filter chips.
     *
     * @return string[]
     */
    public static function categories(): array
    {
        return array_values(array_unique(array_map(fn (self $c) => $c->category(), self::cases())));
    }
}
