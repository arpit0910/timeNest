# TimeNest API Documentation

Base path: `/api/v1`

## Authentication (`/auth`)

Public routes are rate-limited with `throttle:auth`.

### Register
- `POST /api/v1/auth/register`
- Body: `name`, `email`, `password`, `password_confirmation`
- Response: registered user state. Email verification is required before login can continue.

### Login
- `POST /api/v1/auth/login`
- Body: `email`, `password`
- Response:
  - `authenticated`: full access and refresh tokens.
  - `requires_2fa`: temporary token scoped to `2fa`.
  - `requires_workspace_selection`: temporary token scoped to `workspace_selection`.
  - `no_workspace`: identity exists but has no active platform/organization workspace.

### Verify 2FA
- `POST /api/v1/auth/2fa/verify`
- Requires: Bearer temp token with purpose `2fa`
- Body: `code`
- Response: full token pair or workspace-selection state.

### Select Workspace
- `POST /api/v1/auth/select-Organization`
- Requires: Bearer temp token with purpose `workspace_selection`
- Body: `Organization_uuid`
- Response: Organization-scoped token pair.

### Switch Workspace
- `POST /api/v1/auth/switch-Organization`
- Requires: full Bearer token
- Body: `Organization_uuid`
- Response: new Organization-scoped token pair.

### Refresh Token
- `POST /api/v1/auth/refresh`
- Body: `refresh_token`
- Response: new access and refresh token pair. The previous refresh token is consumed atomically.

### Profile And Account
- `GET /api/v1/auth/me`
- `GET /api/v1/auth/workspaces`
- `POST /api/v1/auth/change-password`
- `POST /api/v1/auth/logout`
- `POST /api/v1/auth/logout-all`
- Requires: full Bearer token.

### Verify Email
- `POST /api/v1/auth/verify-email`
- Body: `token`

## Platform Administration (`/platform`)

Requires full platform-guard JWT, active platform membership, and route permission middleware.

### organizations
- `GET /api/v1/platform/organizations`
- `POST /api/v1/platform/organizations`
- `GET /api/v1/platform/organizations/{uuid}`
- `PUT /api/v1/platform/organizations/{uuid}`

## Organization Workspace (`/organization`)

Requires full organization-guard JWT, active Organization membership, resolved tenant context, and route permission middleware.

### Branches
- `GET /api/v1/organization/branches`
- `POST /api/v1/organization/branches`
- `GET /api/v1/organization/branches/{uuid}`
- `PUT /api/v1/organization/branches/{uuid}`
- `DELETE /api/v1/organization/branches/{uuid}`

### Departments
- `GET /api/v1/organization/departments`
- `POST /api/v1/organization/departments`
- `GET /api/v1/organization/departments/{uuid}`
- `PUT /api/v1/organization/departments/{uuid}`
- `DELETE /api/v1/organization/departments/{uuid}`

### Memberships
- `GET /api/v1/organization/memberships`
- `POST /api/v1/organization/memberships`
- `DELETE /api/v1/organization/memberships/{uuid}`

## Attendance Workspace (`/organization/attendance`)

All attendance requests require a valid bearer access token and resolved Organization tenant context.

### Daily Attendance
- `POST /api/v1/organization/attendance/clock-in`
  - Body:
    - `latitude`: Float, required. GPS latitude of the user's device.
    - `longitude`: Float, required. GPS longitude of the user's device.
    - `accuracy`: Float, required. GPS signal accuracy (meters). Rejects > 100m.
    - `device_id`: String, required. Unique hardware device ID identifier.
    - `source`: Integer, required. Source medium (`1` = Mobile, `2` = Web, `3` = AdminPanel, `4` = System).
  - Validation & Behavior:
    - Validates GPS coordinates against the corporate geofence radius.
    - Blocks clock-in if outside geofence (returns `422 OUTSIDE_GEOFENCE`).
    - Bypasses geofencing automatically if user has an approved Work From Home (`LeaveTypeEnum::WorkFromHome`) leave.
    - Rejects clock-in on active holidays unless user has an approved Extra Working Day (`LeaveTypeEnum::ExtraWorkingDay`) leave.
    - Rejects concurrent active clock-ins.

- `POST /api/v1/organization/attendance/clock-out`
  - Body:
    - `latitude`: Float, required.
    - `longitude`: Float, required.
    - `accuracy`: Float, required.
    - `device_id`: String, required.
    - `source`: Integer, required.
  - Behavior:
    - Ends the active clock-in session.
    - Calculates total work duration, break durations, and late minutes based on Organization policy thresholds.
    - Recalculates daily compliance status (`Present`, `HalfDay`, `Absent`) and deducts status based on policy rules.

- `GET /api/v1/organization/attendance/today`
  - Returns: Today's active attendance session details and day summary parameters.

- `GET /api/v1/organization/attendance/history`
  - Query Params:
    - `page`: Integer, optional (Default `1`).
    - `per_page`: Integer, optional.
  - Returns: Paginated historical attendance days list.

## Employee Leaves (`/organization/attendance/leaves`)

- `GET /api/v1/organization/attendance/leaves`
  - Query Params:
    - `page`: Integer, optional.
    - `per_page`: Integer, optional.
    - `status`: Integer/String, optional. Filter by leave status.
    - `leave_type`: Integer/String, optional. Filter by leave type.
  - Returns: Paginated list of leave requests for the authenticated user.

- `POST /api/v1/organization/attendance/leaves`
  - Body:
    - `leave_type`: Integer, required. (`1` = Casual, `2` = Sick, `3` = Casual Unpaid, `4` = Sick Unpaid, `5` = WFH, `6` = EWD, `7` = Maternity/Paternity, `8` = Bereavement).
    - `start_date`: Date (YYYY-MM-DD), required.
    - `end_date`: Date (YYYY-MM-DD), required.
    - `reason`: String, required.
    - `attachment_path`: String, optional.
    - `metadata`: JSON object, optional.
  - Validation:
    - Prevents overlapping pending or approved leave requests.

- `GET /api/v1/organization/attendance/leaves/{uuid}`
  - Returns: Detailed model parameters of the leave by UUID.

- `PATCH /api/v1/organization/attendance/leaves/{uuid}/status`
  - Body:
    - `status`: Integer, required. The target LeaveStatusEnum status value (1-15).
    - `remarks`: String, optional. Remarks/reasoning for the transition (required or recommended for Cancellation, Rejections, etc.).
    - `metadata`: JSON object, optional. Additional audit context.
  - Behavior:
    - Transition the leave through the workflow state machine.
    - Authenticated employees can self-cancel their own pending leaves.
    - Managerial/HR status changes require the `leaves.approve` permission.
    - Records an audit log entry in the `leave_status_histories` table.
    - Updates legacy approved_by/rejected_by fields and cancellation reason where applicable.
    - Triggers recalculation of affected attendance days upon approval/cancellation.

## Attendance Adjustments (`/organization/adjustments`)

Allows correction of erroneous clock-in/out records.

- `GET /api/v1/organization/adjustments`
  - Query Params:
    - `page`: Integer, optional.
    - `per_page`: Integer, optional.
    - `status`: Integer, optional.
  - Returns: Paginated list of adjustment requests.

- `POST /api/v1/organization/adjustments`
  - Body:
    - `attendance_day_id`: Integer, required.
    - `attendance_session_id`: Integer, optional.
    - `adjustment_type`: Integer, required (`1` = ClockInCorrection, `2` = ClockOutCorrection, `3` = SessionDeletion, `4` = ManualAttendance).
    - `clock_in_at`: DateTime (ISO 8601), optional.
    - `clock_out_at`: DateTime (ISO 8601), optional.
    - `reason`: String, required.
  - Validation:
    - Validates datetime ranges and checks consistency.

- `PUT /api/v1/organization/adjustments/{uuid}/approve`
  - Behavior:
    - Manager-only endpoint to approve the correction. recalculates day totals, duration, and compliance status.

- `PUT /api/v1/organization/adjustments/{uuid}/reject`
  - Body:
    - `reason`: String, required.
  - Behavior:
    - Manager-only endpoint to reject the correction.

## Attendance Policy (`/organization/policy`)

- `GET /api/v1/organization/policy`
  - Returns: Active attendance policy parameters for the Organization.

- `PUT /api/v1/organization/policy`
  - Body:
    - `shift_start_time`: Time (HH:MM:SS), required.
    - `shift_end_time`: Time (HH:MM:SS), required.
    - `grace_period_minutes`: Integer, required.
    - `half_day_min_minutes`: Integer, required.
    - `full_day_min_minutes`: Integer, required.
    - `is_strict_mode`: Boolean, required.
    - `overtime_threshold_minutes`: Integer, required.
    - `penalty_rules`: Array, required.
  - Behavior:
    - Updates active policy parameters. Future clock-ins will respect updated shifts and slabs.

## Worklog Compliance Policy (`/organization/attendance/worklog-policy`)

- `GET /api/v1/organization/attendance/worklog-policy`
  - Returns: Current active worklog policy.

- `PATCH /api/v1/organization/attendance/worklog-policy`
  - Body:
    - `require_worklog_on_clockout`: Boolean, optional
    - `allow_deferred_submission`: Boolean, optional
    - `require_project_mapping`: Boolean, optional
    - `require_task_mapping`: Boolean, optional
    - `require_justification_on_overflow`: Boolean, optional
    - `auto_escalate_overdue_logs`: Boolean, optional
    - `overdue_after_days`: Integer, optional
    - `lock_after_days`: Integer, optional
    - `allow_multiple_worklogs_per_session`: Boolean, optional
    - `strict_mode_enabled`: Boolean, optional
    - `flexible_mode_enabled`: Boolean, optional
    - `hybrid_mode_enabled`: Boolean, optional
  - Behavior:
    - Updates active worklog policy fields.

## Attendance Worklogs (`/organization/attendance/worklogs`)

- `GET /api/v1/organization/attendance/worklogs`
  - Query Params:
    - `user_uuid`: String, optional. Filter by user (requires manager/admin permission).
  - Returns: List of worklogs (filtered to active user, or all if manager/admin).

- `POST /api/v1/organization/attendance/worklogs`
  - Body:
    - `attendance_day_uuid`: String, required.
    - `attendance_session_uuid`: String, optional.
    - `project_uuid`: String, optional.
    - `milestone_uuid`: String, optional.
    - `task_uuid`: String, optional.
    - `logged_minutes`: Integer, required.
    - `description`: String, required.
    - `justification`: String, optional.
    - `metadata`: JSON object, optional.
  - Behavior:
    - Submits worklog, allocates task consumption, runs compliance check.

- `GET /api/v1/organization/attendance/worklogs/{uuid}`
  - Returns: Specific worklog details.

- `PATCH /api/v1/organization/attendance/worklogs/{uuid}`
  - Body:
    - `project_uuid`: String, optional.
    - `milestone_uuid`: String, optional.
    - `task_uuid`: String, optional.
    - `logged_minutes`: Integer, optional.
    - `description`: String, optional.
    - `justification`: String, optional.
    - `metadata`: JSON object, optional.
  - Behavior:
    - Updates worklog and recalculates/syncs task consumption.

- `PATCH /api/v1/organization/attendance/worklogs/{uuid}/status`
  - Body:
    - `status`: Integer, required (WorkflowStatusEnum value).
    - `remarks`: String, optional.
    - `metadata`: JSON object, optional.
  - Behavior:
    - Performs state transition checks, records status history, adjusts task/day compliance.

- `DELETE /api/v1/organization/attendance/worklogs/{uuid}`
  - Behavior:
    - Removes worklog if in editable state, frees up logged task consumption minutes.

## Attendance Escalations (`/organization/attendance/escalations`)

- `GET /api/v1/organization/attendance/escalations`
  - Returns: Escalation list.

- `GET /api/v1/organization/attendance/escalations/{uuid}`
  - Returns: Details of the escalation.

- `PATCH /api/v1/organization/attendance/escalations/{uuid}/status`
  - Body:
    - `status`: Integer, required (EscalationStatusEnum value: Resolved or Dismissed).
    - `remarks`: String, optional.
  - Behavior:
    - Resolves or dismisses a pending escalation.

## Organization Invitations (`/organization/invitations`)

Requires `invitations.view`, `invitations.create`, `invitations.revoke`, `invitations.resend` permissions.

- `GET /api/v1/organization/invitations`
  - Query Params:
    - `email`: String, optional. Filter/search by email.
    - `status`: Integer, optional. Filter by status (InvitationStatusEnum).
  - Returns: Paginated list of invitations.

- `GET /api/v1/organization/invitations/{uuid}`
  - Returns: Details of the specific invitation.

- `POST /api/v1/organization/invitations`
  - Body:
    - `email`: String, required. Email address of the user to invite.
    - `role_uuid`: String, required. UUID of the Spatie role to assign.
    - `metadata`: JSON object, optional. Custom invitation metadata.
  - Behavior:
    - Creates invitation, generates hashed token, triggers invitation email.

- `POST /api/v1/organization/invitations/{uuid}/revoke`
  - Behavior:
    - Revokes a pending invitation.

- `POST /api/v1/organization/invitations/{uuid}/resend`
  - Behavior:
    - Extends the expiration date, updates token and resends invitation email.

## Public Invitations (`/invitations`)

Public endpoints (no headers/authentication required).

- `GET /api/v1/invitations/validate/{token}`
  - Returns: Details of the invitation (Organization name, role name, expiry, and whether user already exists).

- `POST /api/v1/invitations/accept`
  - Body:
    - `token`: String, required. Raw invitation token.
    - `name`: String, optional (required for new users). Full name.
    - `password`: String, optional (required for new users). Setup password.
    - `password_confirmation`: String, optional (required if password is provided).
    - `first_name`: String, optional.
    - `last_name`: String, optional.
    - `phone`: String, optional.
    - `timezone`: String, optional.
  - Behavior:
    - Accepts invitation, registers new user if they don't exist, attaches membership, assigns role, and returns corporate JWT tokens (or joins existing user if authenticated).



