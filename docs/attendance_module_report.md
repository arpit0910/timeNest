# Comprehensive Attendance Module Technical Report

This document provides complete, exhaustive architectural and API documentation for the **TimeNest Attendance Module**. It is structured specifically for frontend developers to implement client-side interfaces efficiently and accurately.

---

## 1. Module Overview & Architecture

The Attendance Module tracks daily attendance, clock-in/out sessions, policy enforcement, worklogs, adjustments, and compliance escalations.

```
                      +-----------------------------+
                      |   Attendance Policy &       |
                      |   Version Snapshot          |
                      +--------------+--------------+
                                     |
                                     v
+------------------+       +-------------------+       +-----------------------+
|  User Clock-In   | ----> |  AttendanceDay    | <---- | AttendanceSession(s)  |
|  / Clock-Out     |       |  (Daily Summary)  |       | (Raw Punches)         |
+------------------+       +---------+---------+       +-----------------------+
                                     |
           +-------------------------+-------------------------+
           |                         |                         |
           v                         v                         v
+--------------------+    +--------------------+    +--------------------+
| AttendanceWorklog  |    | Attendance         |    | Attendance         |
| (Activity Logs)    |    | AdjustmentRequest  |    | Escalation         |
+--------------------+    +--------------------+    +--------------------+
```

### Key Core Concepts
1. **AttendanceDay (`attendance_days`)**: Aggregate container for a user's daily record (Date, Status, Total Work/Break Minutes, Late Minutes, Overtime, Compliance Status).
2. **AttendanceSession (`attendance_sessions`)**: Individual punch intervals (Clock In timestamp/IP/coordinates and Clock Out timestamp/IP/coordinates). Multiple sessions per day are supported if enabled in the policy.
3. **AttendancePolicy & Versioning (`attendance_policies` & `attendance_policy_versions`)**: Organization-wide rules. Every `AttendanceDay` stores an immutable snapshot ID (`attendance_policy_version_id`) captured on the day's first clock-in.
4. **AttendanceWorklog (`attendance_worklogs`)**: Granular time logs mapped to projects, milestones, and tasks for attendance compliance.
5. **AttendanceAdjustmentRequest (`attendance_adjustment_requests`)**: Formal employee requests to correct punch times or manually insert attendance.
6. **AttendanceEscalation (`attendance_escalations`)**: Compliance triggers for overdue worklogs, missing logs, or policy violations requiring manager/HR resolution.

---

## 2. Permissions & Authorization Matrix

All endpoints require standard authentication via Sanctum/Tenant middleware and check granular permissions defined in `App\Enums\SystemPermission`.

### System Permissions List

| Permission Name | String Value | Frontend Scope / Target Component |
| :--- | :--- | :--- |
| **Attendance View** | `attendance.view` | View personal & team attendance histories/today view |
| **Attendance Create** | `attendance.create` | Perform Clock-In & Clock-Out |
| **Attendance Edit** | `attendance.edit` | Edit raw attendance records |
| **Attendance Delete** | `attendance.delete` | Soft delete attendance days/sessions |
| **Attendance Approve** | `attendance.approve` | Approve/Reject attendance adjustments & days |
| **Attendance Approve Any** | `attendance.approve_any` | Cross-department manager approval override |
| **Attendance Export** | `attendance.export` | Download CSV/Excel reports |
| **Attendance Policy View**| `attendance_policy.view` | View organization attendance policy |
| **Attendance Policy Manage**| `attendance_policy.manage` | Edit/Update attendance policy & penalty slabs |
| **Adjustments View** | `attendance_adjustments.view` | View adjustment requests listing |
| **Adjustments Create** | `attendance_adjustments.create` | Submit attendance correction requests |
| **Escalations View** | `attendance_escalations.view` | View compliance escalations list |
| **Escalations Resolve** | `attendance_escalations.resolve` | Resolve or dismiss escalation alerts |
| **Worklog View** | `worklog.view` | View employee worklogs |
| **Worklog Create** | `worklog.create` | Log task hours / submit worklogs |
| **Worklog Approve** | `worklog.approve` | Manager approval for worklogs |
| **Worklog Policy View** | `worklog_policy.view` | View worklog policy settings |
| **Worklog Policy Manage**| `worklog_policy.manage` | Configure worklog policy rules |

### Hierarchy Resolution Rules
* **Standard Employees**: Can only view/manage their own records (`user_id === auth()->id()`).
* **Managers / Admins**: Can view and approve subordinate records if they hold `attendance.view` or `attendance.approve` AND pass organizational approval hierarchy checks (`ResolvesApprovalHierarchy`).

---

## 3. Detailed Endpoint Specification & Listing Filters

Base URL Prefix: `/api/v1/organization/attendance`

### 3.1 Clock In & Out Endpoints

#### `POST /clock-in`
* **Permission**: `attendance.create`
* **Request Body** (`ClockInRequest`):
  ```json
  {
    "clock_in_source": 2,            // Required (Integer Enum: 1=Mobile, 2=Web, 3=Admin, 4=System)
    "clock_in_device_id": "string",  // Optional (Max 255 chars)
    "clock_in_latitude": 19.0760,    // Required (Numeric between -90 and 90)
    "clock_in_longitude": 72.8777,   // Required (Numeric between -180 and 180)
    "clock_in_accuracy": 15.5        // Optional (Non-negative numeric)
  }
  ```
* **Validation & Execution Flow**:
  1. Resolves user timezone from employee branch profile (`resolveTodayDate`).
  2. Creates or finds today's `AttendanceDay` record.
  3. Checks if an open session currently exists (throws `ACTIVE_SESSION_EXISTS` if active).
  4. Checks if policy allows multiple sessions (`MULTIPLE_SESSIONS_BLOCKED`).
  5. Checks holiday & weekend restrictions (`HOLIDAY_CLOCK_IN_BLOCKED`, `WEEKEND_CLOCK_IN_BLOCKED`). Bypassed if user has an approved Extra Working Day (EWD).
  6. Checks active leaves (`LEAVE_ACTIVE_CLOCK_IN_BLOCKED`).
  7. Validates Geofence:
     * In **STRICT** mode: Fails with `LOCATION_REQUIRED` or `OUTSIDE_GEOFENCE` exception.
     * In **FLEXIBLE/HYBRID** mode: Allows clock-in but sets `is_suspicious = true` with `suspicious_reason`.
  8. Enforces strict worklog submission for previous working day (if `strict_worklog_enforcement` is enabled). Fails with `WorklogEnforcementBlockException`.

#### `POST /clock-out`
* **Permission**: `attendance.create`
* **Request Body** (`ClockOutRequest`):
  ```json
  {
    "clock_out_source": 2,            // Required (Integer Enum: 1=Mobile, 2=Web, 3=Admin, 4=System)
    "clock_out_device_id": "string",  // Optional
    "clock_out_latitude": 19.0760,    // Required
    "clock_out_longitude": 72.8777,   // Required
    "clock_out_accuracy": 12.0        // Optional
  }
  ```
* **Validation & Execution Flow**:
  1. Finds the active `AttendanceSession` for today where `clock_out_at IS NULL`. Fails with `NO_ACTIVE_SESSION` if none exists.
  2. Performs geofence check (flags `is_suspicious` if outside, but **never** blocks clock-out).
  3. Updates session with clock-out timestamp and metadata.
  4. Triggers `recalculateDay()` / `recompute()` to recalculate work minutes, break minutes, late minutes, overtime, attendance status, and compliance status.

---

### 3.2 Today & History Summary Endpoints

#### `GET /today`
* **Permission**: `attendance.view`
* **Query Params**: None
* **Description**: Returns today's `AttendanceDay` object along with all related `attendanceSessions`.
* **Response Payload**: `AttendanceDayResource` object (or `null` with message if no clock-in exists).

#### `GET /history`
* **Permission**: `attendance.view`
* **Query Params** (`AttendanceHistoryRequest`):
  | Parameter | Type | Required | Description / Values |
  | :--- | :--- | :--- | :--- |
  | `start_date` / `from` | `string` (Y-m-d) | No | Filter records on or after date |
  | `end_date` / `to` | `string` (Y-m-d) | No | Filter records on or before date |
  | `status` | `integer` | No | Filter by `AttendanceStatusEnum` (1-7) |
  | `per_page` | `integer` | No | Items per page (default: 30, min: 5, max: 100) |
* **Response Payload**: Paginated `AttendanceDayResource` collection.

---

### 3.3 Attendance Worklogs Endpoints

#### `GET /worklogs`
* **Permission**: `worklog.view`
* **Query Parameters**:
  * `user_uuid` (`string`): Filter worklogs for a specific user (Requires view-all permission).
  * `status` (`integer`): Filter by `WorklogStatus` (1=Draft, 2=Submitted, 3=Approved, 4=Rejected, 5=Auto Approved, 6=Locked).
  * `from` (`string` Y-m-d): Filter by creation start date.
  * `to` (`string` Y-m-d): Filter by creation end date.

#### `GET /days/{dayUuid}/worklogs`
* **Permission**: `worklog.view`
* **Description**: Returns all worklogs submitted for a specific attendance day.

#### `POST /days/{dayUuid}/worklogs`
* **Permission**: `worklog.create`
* **Request Body** (`StoreAttendanceWorklogRequest`):
  ```json
  {
    "attendance_day_uuid": "uuid",       // Required (Inferred from route)
    "attendance_session_uuid": "uuid",   // Optional
    "project_uuid": "uuid",              // Optional (Required if policy enforces project mapping)
    "milestone_uuid": "uuid",            // Optional
    "task_uuid": "uuid",                 // Optional (Required if policy enforces task mapping)
    "start_time": "2026-08-08 09:30:00", // Optional (Y-m-d H:i:s, must be within last 15 days)
    "end_time": "2026-08-08 13:00:00",   // Optional (Y-m-d H:i:s, after start_time)
    "logged_minutes": 210,               // Optional integer
    "description": "Implemented Auth",   // Optional string (Min length enforced by policy if enabled)
    "justification": "Overtime work",    // Optional string (Required on task estimate overflow)
    "metadata": {}                       // Optional array
  }
  ```

#### `PUT /worklogs/{uuid}`
* **Permission**: `worklog.create` (Only owner can update unapproved/unlocked worklogs)
* **Request Body**: Same fields as `StoreAttendanceWorklogRequest` (all optional via `UpdateAttendanceWorklogRequest`).

#### `POST /worklogs/{uuid}/approve` & `POST /worklogs/{uuid}/reject`
* **Permission**: `worklog.approve`
* **Approve Payload**: `{"remarks": "string"}`
* **Reject Payload**: `{"rejection_reason": "string"}` (Required)

---

### 3.4 Attendance Adjustments Endpoints

#### `GET /adjustments`
* **Permission**: `attendance_adjustments.view`
* **Description**: List all attendance correction requests for the tenant.

#### `POST /adjustments`
* **Permission**: `attendance_adjustments.create`
* **Request Body** (`AdjustmentRequest`):
  ```json
  {
    "attendance_day_uuid": "uuid",       // Required
    "attendance_session_uuid": "uuid",   // Optional (Required for clock-in/out correction or deletion)
    "adjustment_type": 1,                // Required Enum: 1=Clock-In Correction, 2=Clock-Out Correction, 3=Session Deletion, 4=Manual Entry
    "clock_in_at": "2026-08-08 09:00:00",// Required for types 1 & 4
    "clock_out_at": "2026-08-08 17:00:00",// Required for type 2, Optional for 4
    "reason": "Forgot to clock in"      // Required string (max 255)
  }
  ```

#### `PUT /adjustments/{uuid}/approve` & `PUT /adjustments/{uuid}/reject`
* **Permission**: `attendance.approve`
* **Reject Body**: `{"reason": "Invalid justification"}`

---

### 3.5 Attendance Escalations Endpoints

#### `GET /escalations`
* **Permission**: `attendance_escalations.view`
* **Description**: Lists escalations triggered by system compliance checks.

#### `PATCH /escalations/{uuid}/status`
* **Permission**: `attendance_escalations.resolve`
* **Request Body** (`UpdateAttendanceEscalationStatusRequest`):
  ```json
  {
    "status": 2, // Required Enum: 2=Resolved, 3=Dismissed
    "remarks": "Reviewed and verified worklog" // Optional string
  }
  ```

---

### 3.6 Attendance Policy & Worklog Policy Endpoints

#### `GET /policy` & `PUT /policy`
* **Permissions**: `attendance_policy.view` (GET) / `attendance_policy.manage` (PUT)
* **PUT Body** (`UpdateAttendancePolicyRequest`):
  ```json
  {
    "attendance_mode": 1,                 // 1=Strict, 2=Flexible, 3=Hybrid
    "approval_flow": 2,                  // 1=Auto, 2=Single Approval, 3=Multi-Level
    "shift_start_time": "09:00:00",      // H:i:s
    "shift_end_time": "17:00:00",        // H:i:s
    "required_daily_minutes": 480,       // Integer (e.g. 8 hours = 480)
    "minimum_session_minutes": 60,
    "grace_late_minutes": 15,
    "allowed_monthly_late_count": 3,
    "allow_early_exit": false,
    "grace_early_exit_minutes": 0,
    "default_break_minutes": 60,
    "max_break_minutes": 60,
    "allow_multiple_sessions": true,
    "allow_clock_in_on_holidays": false,
    "auto_clock_out_enabled": false,
    "auto_clock_out_after_minutes": 120,
    "overtime_enabled": true,
    "overtime_starts_after_minutes": 480,
    "max_daily_overtime_minutes": 240,
    "overtime_requires_approval": true,
    "weekend_days": [6, 7],               // ISO integers: 1=Mon ... 7=Sun
    "geo_fencing_enabled": true,
    "geo_fence_radius_meters": 200,      // Range: 50 to 50000
    "ip_restriction_enabled": false,
    "strict_worklog_enforcement": false,
    "late_penalty_slabs": [
      {
        "late_count_threshold": 4,       // Deduction applies on 4th late
        "deduction_percentage": 50.00   // 50% half-day pay deduction
      }
    ],
    "work_duration_penalty_slabs": [
      {
        "min_work_minutes": 0,
        "max_work_minutes": 239,
        "deduction_percentage": 100.00  // Less than 4 hours = Full day deduction
      },
      {
        "min_work_minutes": 240,
        "max_work_minutes": 479,
        "deduction_percentage": 50.00   // 4 to 8 hours = Half day deduction
      }
    ]
  }
  ```

#### `GET /worklog-policy` & `PATCH /worklog-policy`
* **Permissions**: `worklog_policy.view` (GET) / `worklog_policy.manage` (PATCH)

---

## 4. Policy Engine & Attendance Computation Mechanics

### 4.1 Attendance Modes
1. **STRICT (Value = 1)**:
   * Enforces shift start and end times.
   * Computes **Late Minutes** if clock-in is past `shift_start_time + grace_late_minutes`.
   * Computes **Early Exit Minutes** if clock-out is before `shift_end_time`.
   * Geofencing violations hard-block clock-in attempts.
2. **FLEXIBLE (Value = 2)**:
   * Only total daily work minutes are evaluated against `required_daily_minutes`.
   * Late minutes and early exit minutes are always `0`.
   * Geofencing violations allow clock-in but flag the session as **suspicious**.
3. **HYBRID (Value = 3)**:
   * Enforces shift start time (calculates late minutes).
   * Exit time is flexible.

### 4.2 Calculation Pipeline (`recalculateDay` / `recompute`)
When a session is clocked out or an adjustment is approved, the system calculates:
1. **Total Work Minutes**: Sum of `(clock_out_at - clock_in_at)` in minutes for all completed sessions.
2. **Total Break Minutes**: Sum of gap intervals between consecutive sessions `(next.clock_in_at - previous.clock_out_at)`.
3. **Overtime Minutes**: `max(0, totalWorkMinutes - overtime_starts_after_minutes)`, capped by `max_daily_overtime_minutes`.
4. **Attendance Status Resolution**:
   * If 0 sessions and Approved Leave exists -> `LEAVE (4)`
   * If 0 sessions and Holiday exists -> `HOLIDAY (5)`
   * If 0 sessions and Weekend exists -> `WEEKEND (6)`
   * If 0 sessions and Unexcused -> `ABSENT (1)`
   * If open session exists and date is Today -> `INCOMPLETE (7)`
   * If completed sessions:
     * `totalWorkMinutes >= required_daily_minutes` -> `PRESENT (2)`
     * Work duration penalty slab check: If deduction is 100% -> `ABSENT (1)`. If deduction is 50% or `totalWorkMinutes >= (required / 2)` -> `HALF_DAY (3)`.
5. **Compliance Status Resolution**:
   * Default -> `COMPLIANT (1)`
   * Unexcused Absence -> `OVERDUE (3)`
   * Late count in month > `allowed_monthly_late_count` -> `PAYROLL_RISK (5)`
   * Pending Worklog submission (under strict worklog enforcement) -> `PENDING (2)`

---

## 5. Frontend Resource Schemas & Types

### 5.1 `AttendanceDayResource`
```json
{
  "uuid": "string (UUID)",
  "attendance_date": "2026-08-08",
  "attendance_status": {
    "value": 2,
    "label": "Present",
    "color": "#10B981"
  },
  "compliance_status": {
    "value": 1,
    "label": "Compliant",
    "color": "#10B981"
  },
  "total_work_minutes": 480,
  "formatted_duration": "08h 00m",
  "total_break_minutes": 60,
  "total_sessions": 1,
  "late_minutes": 0,
  "early_exit_minutes": 0,
  "overtime_minutes": 0,
  "sessions": [ /* AttendanceSessionResource array */ ]
}
```

### 5.2 `AttendanceSessionResource`
```json
{
  "uuid": "string (UUID)",
  "clock_in_at": "2026-08-08T09:00:00+00:00",
  "clock_out_at": "2026-08-08T17:00:00+00:00",
  "clock_in_source": { "value": 2, "label": "Web Portal", "color": "#10B981" },
  "clock_out_source": { "value": 2, "label": "Web Portal", "color": "#10B981" },
  "clock_in_latitude": 19.0760,
  "clock_in_longitude": 72.8777,
  "clock_out_latitude": 19.0760,
  "clock_out_longitude": 72.8777,
  "is_suspicious": false,
  "suspicious_reason": null
}
```

---

## 6. Comprehensive Enum Reference Table

| Enum Class | Case Name | Int Value | Label | UI Color |
| :--- | :--- | :---: | :--- | :--- |
| **AttendanceStatusEnum** | `ABSENT` | 1 | Absent | `#EF4444` (Red) |
| | `PRESENT` | 2 | Present | `#10B981` (Green) |
| | `HALF_DAY` | 3 | Half Day | `#F59E0B` (Orange) |
| | `LEAVE` | 4 | Leave | `#3B82F6` (Blue) |
| | `HOLIDAY` | 5 | Holiday | `#8B5CF6` (Purple) |
| | `WEEKEND` | 6 | Weekend | `#6B7280` (Gray) |
| | `INCOMPLETE` | 7 | Incomplete | `#EC4899` (Pink) |
| **AttendanceComplianceStatusEnum** | `COMPLIANT` | 1 | Compliant | `#10B981` (Green) |
| | `PENDING` | 2 | Pending | `#F59E0B` (Orange) |
| | `OVERDUE` | 3 | Overdue | `#F97316` (Dark Orange)|
| | `ESCALATED` | 4 | Escalated | `#EF4444` (Red) |
| | `PAYROLL_RISK` | 5 | Payroll Risk | `#7F1D1D` (Dark Red) |
| **AttendanceModeEnum** | `STRICT` | 1 | Strict | `#EF4444` (Red) |
| | `FLEXIBLE` | 2 | Flexible | `#10B981` (Green) |
| | `HYBRID` | 3 | Hybrid | `#3B82F6` (Blue) |
| **AttendanceSessionSourceEnum**| `MOBILE` | 1 | Mobile App | `#3B82F6` (Blue) |
| | `WEB` | 2 | Web Portal | `#10B981` (Green) |
| | `ADMIN_PANEL` | 3 | Admin Panel | `#8B5CF6` (Purple) |
| | `SYSTEM` | 4 | System Automations | `#6B7280` (Gray) |
| **AttendanceAdjustmentTypeEnum**| `CLOCK_IN_CORRECTION` | 1 | Clock-In Correction | `#3B82F6` (Blue) |
| | `CLOCK_OUT_CORRECTION` | 2 | Clock-Out Correction| `#10B981` (Green) |
| | `SESSION_DELETION` | 3 | Session Deletion | `#EF4444` (Red) |
| | `MANUAL_ATTENDANCE` | 4 | Manual Attendance | `#F59E0B` (Orange) |
| **AttendanceAdjustmentStatusEnum**|`PENDING` | 1 | Pending | `#F59E0B` (Orange) |
| | `APPROVED` | 2 | Approved | `#10B981` (Green) |
| | `REJECTED` | 3 | Rejected | `#EF4444` (Red) |
| | `CANCELLED` | 4 | Cancelled | `#6B7280` (Gray) |
| **WorklogStatus** | `DRAFT` | 1 | Draft | `gray` |
| | `SUBMITTED` | 2 | Submitted | `blue` |
| | `APPROVED` | 3 | Approved | `green` |
| | `REJECTED` | 4 | Rejected | `red` |
| | `AUTO_APPROVED` | 5 | Auto Approved | `green` |
| | `LOCKED` | 6 | Locked | `gray` |
| **EscalationTypeEnum** | `OVERDUE_WORKLOG` | 1 | Overdue Worklog Submission | - |
| | `LOW_PRODUCTIVITY` | 2 | Repeated Low Productivity | - |
| | `MISSING_LOG` | 3 | Missing Worklog | - |
| | `EXCESSIVE_OVERFLOW` | 4 | Excessive Task Estimate Overflow | - |
| | `REPEATED_REJECTION` | 5 | Repeated Worklog Rejections | - |
| | `COMPLIANCE_VIOLATION` | 6 | Compliance Violation | - |
| **EscalationStatusEnum** | `PENDING` | 1 | Pending Resolution | - |
| | `RESOLVED` | 2 | Resolved | - |
| | `DISMISSED` | 3 | Dismissed | - |

---

## 7. Default Policy Parameters (Fallback Defaults)

When an organization accesses policy endpoints before creating a custom policy, the system auto-initializes the following default policy (`createDefaultPolicy`):

```json
{
  "attendance_mode": 2,                    // Flexible
  "approval_flow": 1,                     // Auto
  "shift_start_time": "09:00:00",
  "shift_end_time": "17:00:00",
  "required_daily_minutes": 480,          // 8 Hours
  "minimum_session_minutes": 60,           // 1 Hour minimum
  "grace_late_minutes": 15,               // 15 Mins grace
  "allowed_monthly_late_count": 3,         // 3 Lates per month permitted
  "allow_early_exit": false,
  "grace_early_exit_minutes": 0,
  "default_break_minutes": 60,
  "max_break_minutes": 60,
  "allow_multiple_sessions": true,
  "allow_clock_in_on_holidays": false,
  "auto_clock_out_enabled": false,
  "auto_clock_out_after_minutes": 120,
  "overtime_enabled": false,
  "overtime_starts_after_minutes": 60,
  "max_daily_overtime_minutes": 240,
  "overtime_requires_approval": true,
  "weekend_days": [6, 7],                  // Saturday & Sunday
  "geo_fencing_enabled": false,
  "geo_fence_radius_meters": 100,
  "ip_restriction_enabled": false,
  "strict_worklog_enforcement": false
}
```

---

## 8. Summary Checklist for Frontend Implementation

1. **Geolocation Integration**: Always capture browser/device HTML5 `navigator.geolocation` coordinates (`latitude`, `longitude`, `accuracy`) before invoking `/clock-in` or `/clock-out`.
2. **Timezone Handling**: Send dates formatted in `Y-m-d` for history queries. Display timestamps localized to the employee's assigned branch timezone.
3. **Suspicious Punch Banner**: If `is_suspicious === true` on an `AttendanceSession`, display a warning badge with `suspicious_reason` in the UI.
4. **State Machine Controls**:
   * Disable "Clock In" button if an active session exists (`clock_out_at === null`).
   * Enable "Clock Out" button if an active session exists.
   * Hide "Worklog Edit/Delete" buttons if worklog status is `APPROVED (3)` or `LOCKED (6)`.
5. **Role-Based Views**: Use system permissions (`attendance.approve`, `worklog.approve`, `attendance_escalations.resolve`) to conditionally display Manager Review dashboards vs Employee Personal dashboards.
