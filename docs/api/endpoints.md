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
  - `no_workspace`: identity exists but has no active platform/corp workspace.

### Verify 2FA
- `POST /api/v1/auth/2fa/verify`
- Requires: Bearer temp token with purpose `2fa`
- Body: `code`
- Response: full token pair or workspace-selection state.

### Select Workspace
- `POST /api/v1/auth/select-corporation`
- Requires: Bearer temp token with purpose `workspace_selection`
- Body: `corporation_uuid`
- Response: corporation-scoped token pair.

### Switch Workspace
- `POST /api/v1/auth/switch-corporation`
- Requires: full Bearer token
- Body: `corporation_uuid`
- Response: new corporation-scoped token pair.

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

### Corporations
- `GET /api/v1/platform/corporations`
- `POST /api/v1/platform/corporations`
- `GET /api/v1/platform/corporations/{uuid}`
- `PUT /api/v1/platform/corporations/{uuid}`

## Corporation Workspace (`/corp`)

Requires full corp-guard JWT, active corporation membership, resolved tenant context, and route permission middleware.

### Branches
- `GET /api/v1/corp/branches`
- `POST /api/v1/corp/branches`
- `GET /api/v1/corp/branches/{uuid}`
- `PUT /api/v1/corp/branches/{uuid}`
- `DELETE /api/v1/corp/branches/{uuid}`

### Departments
- `GET /api/v1/corp/departments`
- `POST /api/v1/corp/departments`
- `GET /api/v1/corp/departments/{uuid}`
- `PUT /api/v1/corp/departments/{uuid}`
- `DELETE /api/v1/corp/departments/{uuid}`

### Memberships
- `GET /api/v1/corp/memberships`
- `POST /api/v1/corp/memberships`
- `DELETE /api/v1/corp/memberships/{uuid}`

## Attendance Workspace (`/corp/attendance`)

All attendance requests require a valid bearer access token and resolved corporation tenant context.

### Daily Attendance
- `POST /api/v1/corp/attendance/clock-in`
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

- `POST /api/v1/corp/attendance/clock-out`
  - Body:
    - `latitude`: Float, required.
    - `longitude`: Float, required.
    - `accuracy`: Float, required.
    - `device_id`: String, required.
    - `source`: Integer, required.
  - Behavior:
    - Ends the active clock-in session.
    - Calculates total work duration, break durations, and late minutes based on corporation policy thresholds.
    - Recalculates daily compliance status (`Present`, `HalfDay`, `Absent`) and deducts status based on policy rules.

- `GET /api/v1/corp/attendance/today`
  - Returns: Today's active attendance session details and day summary parameters.

- `GET /api/v1/corp/attendance/history`
  - Query Params:
    - `page`: Integer, optional (Default `1`).
    - `per_page`: Integer, optional.
  - Returns: Paginated historical attendance days list.

## Employee Leaves (`/corp/attendance/leaves`)

- `GET /api/v1/corp/attendance/leaves`
  - Query Params:
    - `page`: Integer, optional.
    - `per_page`: Integer, optional.
    - `status`: Integer/String, optional. Filter by leave status.
    - `leave_type`: Integer/String, optional. Filter by leave type.
  - Returns: Paginated list of leave requests for the authenticated user.

- `POST /api/v1/corp/attendance/leaves`
  - Body:
    - `leave_type`: Integer, required. (`1` = Casual, `2` = Sick, `3` = Casual Unpaid, `4` = Sick Unpaid, `5` = WFH, `6` = EWD, `7` = Maternity/Paternity, `8` = Bereavement).
    - `start_date`: Date (YYYY-MM-DD), required.
    - `end_date`: Date (YYYY-MM-DD), required.
    - `reason`: String, required.
    - `attachment_path`: String, optional.
    - `metadata`: JSON object, optional.
  - Validation:
    - Prevents overlapping pending or approved leave requests.

- `GET /api/v1/corp/attendance/leaves/{uuid}`
  - Returns: Detailed model parameters of the leave by UUID.

- `PATCH /api/v1/corp/attendance/leaves/{uuid}/status`
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

## Attendance Adjustments (`/corp/adjustments`)

Allows correction of erroneous clock-in/out records.

- `GET /api/v1/corp/adjustments`
  - Query Params:
    - `page`: Integer, optional.
    - `per_page`: Integer, optional.
    - `status`: Integer, optional.
  - Returns: Paginated list of adjustment requests.

- `POST /api/v1/corp/adjustments`
  - Body:
    - `attendance_day_id`: Integer, required.
    - `attendance_session_id`: Integer, optional.
    - `adjustment_type`: Integer, required (`1` = ClockInCorrection, `2` = ClockOutCorrection, `3` = SessionDeletion, `4` = ManualAttendance).
    - `clock_in_at`: DateTime (ISO 8601), optional.
    - `clock_out_at`: DateTime (ISO 8601), optional.
    - `reason`: String, required.
  - Validation:
    - Validates datetime ranges and checks consistency.

- `PUT /api/v1/corp/adjustments/{uuid}/approve`
  - Behavior:
    - Manager-only endpoint to approve the correction. recalculates day totals, duration, and compliance status.

- `PUT /api/v1/corp/adjustments/{uuid}/reject`
  - Body:
    - `reason`: String, required.
  - Behavior:
    - Manager-only endpoint to reject the correction.

## Attendance Policy (`/corp/policy`)

- `GET /api/v1/corp/policy`
  - Returns: Active attendance policy parameters for the corporation.

- `PUT /api/v1/corp/policy`
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

