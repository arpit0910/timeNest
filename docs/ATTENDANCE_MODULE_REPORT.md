# Technical Audit Report: Attendance Module

**Generated:** 2026-08-08  
**Scope:** `app/Http/Controllers/Api/V1/Organization/Attendance/AttendanceController.php`, `AttendanceAdjustmentController.php`, `AttendancePolicyController.php`, `AttendanceEscalationController.php`, `AttendanceService.php`, `AttendanceCalculationService.php`

---

## 1. Module Overview & Architecture

### Business Problem Solved
The Attendance Module manages real-time employee time tracking, shift compliance, geofenced clock-in/clock-out events, attendance adjustment workflows, policy violation escalations, and daily attendance aggregation for payroll calculation across multi-tenant organizations.

### Entity Relationship Diagram
```
  ┌─────────────────┐       1:N       ┌──────────────────────┐
  │  Organization   │─────────────────│    AttendanceDay     │
  └─────────────────┘                 └──────────────────────┘
           │ 1:1                                 │ 1:N
           ▼                                     ▼
  ┌─────────────────┐                 ┌──────────────────────┐
  │ AttendancePolicy│                 │  AttendanceSession   │
  └─────────────────┘                 └──────────────────────┘
           │ 1:N                                 │ 1:N
           ▼                                     ▼
  ┌──────────────────────┐            ┌──────────────────────┐
  │AttendancePolicyVer.  │            │  AttendanceWorklog   │
  └──────────────────────┘            └──────────────────────┘
           │ 1:N                                 │ 1:N
           ├────────────────────────┐            │
           ▼                        ▼            ▼
  ┌──────────────────────┐┌────────────────────────┐
  │ AttendanceLateSlab   ││AttendanceWorkDurSlab   │
  └──────────────────────┘└────────────────────────┘
           │
           │ 1:N
           ▼
  ┌──────────────────────┐            ┌──────────────────────┐
  │AttendanceAdjustment  │            │ AttendanceEscalation │
  └──────────────────────┘            └──────────────────────┘
```

---

## 2. Permissions & Authorization Matrix

| Permission Name | String Value | Frontend Scope | STATUS |
| :--- | :--- | :--- | :--- |
| `ATTENDANCE_VIEW` | `attendance.view` | View own / team daily attendance & history | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:47`) |
| `ATTENDANCE_CREATE` | `attendance.create` | Perform clock-in and clock-out actions | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:48`) |
| `ATTENDANCE_EDIT` | `attendance.edit` | Direct edit of attendance records | ❌ MISSING (seeded in enum line 49, no route or controller method) |
| `ATTENDANCE_DELETE` | `attendance.delete` | Hard delete of attendance records | ❌ MISSING (seeded in enum line 50, no route or controller method) |
| `ATTENDANCE_APPROVE` | `attendance.approve` | Approve/reject team attendance adjustments | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:51`) |
| `ATTENDANCE_APPROVE_ANY` | `attendance.approve_any` | Cross-department adjustment approval bypass | ✅ IMPLEMENTED (`app/Services/Attendance/AttendanceService.php:382`) |
| `ATTENDANCE_EXPORT` | `attendance.export` | Export attendance summary reports | ❌ MISSING (seeded in enum line 53, no route or controller method) |
| `ATTENDANCE_IMPORT` | `attendance.import` | Bulk import attendance logs | ❌ MISSING (seeded in enum line 54, no route or controller method) |
| `ATTENDANCE_POLICY_VIEW` | `attendance_policy.view` | View active organization attendance policy | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:55`) |
| `ATTENDANCE_POLICY_MANAGE`| `attendance_policy.manage` | Update organization attendance policy & slabs | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:56`) |
| `ATTENDANCE_ADJUSTMENTS_VIEW`| `attendance_adjustments.view` | List pending/past attendance adjustments | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:57`) |
| `ATTENDANCE_ADJUSTMENTS_CREATE`| `attendance_adjustments.create` | Submit manual attendance adjustment request | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:58`) |
| `ATTENDANCE_ESCALATIONS_VIEW`| `attendance_escalations.view` | View attendance policy violation escalations | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:59`) |
| `ATTENDANCE_ESCALATIONS_RESOLVE`| `attendance_escalations.resolve` | Resolve or dismiss attendance escalations | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:60`) |

> **Permission Audit Note:** `platform.*` permissions (e.g. `platform.full_access`) correctly bypass hierarchy checks when resolved in `AttendanceService` (`app/Services/Attendance/AttendanceService.php:383`).

---

## 3. Endpoint Specification

### 3.1 `POST /api/v1/organization/attendance/clock-in`
* **Permission Required:** `attendance.create` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:17`)
* **Request Body:** (`ClockInRequest.php`) ✅ IMPLEMENTED (`app/Http/Requests/Attendance/ClockInRequest.php:24`)
  * `clock_in_source` (required, int, `enum:AttendanceSessionSourceEnum`)
  * `clock_in_device_id` (optional, string, max:255)
  * `clock_in_latitude` (required, numeric, -90 to 90)
  * `clock_in_longitude` (required, numeric, -180 to 180)
  * `clock_in_accuracy` (optional, numeric, min:0)
* **Response Payload:** `AttendanceSessionResource` ✅ IMPLEMENTED (`app/Http/Resources/Attendance/AttendanceSessionResource.php:23`)
* **Execution Flow:**
  1. `AttendanceController::clockIn` validates request via `ClockInRequest`.
  2. Calls `AttendanceService::clockIn($user, $organization, $data)`.
  3. `GeofenceService::validateGeofence` verifies coordinates against active branch geofence.
  4. Creates `AttendanceSession` record and resolves/updates `AttendanceDay`.
  5. Recalculates day aggregates via `AttendanceCalculationService::recalculateDay`.

### 3.2 `POST /api/v1/organization/attendance/clock-out`
* **Permission Required:** `attendance.create` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:18`)
* **Request Body:** (`ClockOutRequest.php`) ✅ IMPLEMENTED (`app/Http/Requests/Attendance/ClockOutRequest.php:24`)
  * `clock_out_source` (required, int, `enum:AttendanceSessionSourceEnum`)
  * `clock_out_device_id` (optional, string, max:255)
  * `clock_out_latitude` (required, numeric, -90 to 90)
  * `clock_out_longitude` (required, numeric, -180 to 180)
  * `clock_out_accuracy` (optional, numeric, min:0)
* **Response Payload:** `AttendanceSessionResource` ✅ IMPLEMENTED
* **Execution Flow:**
  1. Finds active session without `clock_out_at`.
  2. Sets `clock_out_at` and stores location metadata.
  3. Recalculates total duration and triggers `AttendanceCalculationService::recalculateDay`.

### 3.3 `GET /api/v1/organization/attendance/today`
* **Permission Required:** `attendance.view` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:19`)
* **Query Filters:**
  * `user_uuid` (optional, string, uuid, `exists:users,uuid`) — ✅ IMPLEMENTED (`app/Http/Requests/Attendance/AttendanceTodayRequest.php:24`)
* **Hierarchy Auto-Scoping:** ✅ IMPLEMENTED (`app/Services/Attendance/AttendanceService.php:465`). Standard users can only view self; managers can view subordinates (`reports_to` → dept head fallback). Unauthorized access throws 403 `CANNOT_VIEW_USER_ATTENDANCE`.
* **Response Payload:** `AttendanceDayResource` (includes injected `user` identity object) ✅ IMPLEMENTED (`app/Http/Resources/Attendance/AttendanceDayResource.php:26`).

### 3.4 `GET /api/v1/organization/attendance/history`
* **Permission Required:** `attendance.view` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:20`)
* **Query Filters:**
  * `user_uuid` (optional, string, uuid) — ✅ IMPLEMENTED (`app/Http/Requests/Attendance/AttendanceHistoryRequest.php:25`)
  * `from` / `start_date` (optional, date, Y-m-d) — ✅ IMPLEMENTED
  * `to` / `end_date` (optional, date, Y-m-d) — ✅ IMPLEMENTED
  * `status` (optional, integer, enum) — ✅ IMPLEMENTED
  * `per_page` (optional, integer, min:5, max:100, default:30) — ✅ IMPLEMENTED
* **Query Targeting:** Queries against `attendance_date` column ✅ IMPLEMENTED (`app/Services/Attendance/AttendanceService.php:437`).
* **Response Payload:** `AttendanceDayResource` collection (Paginated) ✅ IMPLEMENTED.

### 3.5 `GET /api/v1/organization/attendance/adjustments`
* **Permission Required:** `attendance_adjustments.view` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:33`)
* **Query Filters:**
  * `user_uuid` (optional, string, uuid) — ✅ IMPLEMENTED (`app/Http/Requests/Attendance/AdjustmentListRequest.php:24`)
  * `status` (optional, int) — ✅ IMPLEMENTED
  * `adjustment_type` (optional, int) — ✅ IMPLEMENTED
  * `from` / `start_date` (optional, date, Y-m-d) — ✅ IMPLEMENTED
  * `to` / `end_date` (optional, date, Y-m-d) — ✅ IMPLEMENTED
  * `per_page` (optional, int, min:5, max:100, default:30) — ✅ IMPLEMENTED
* **Hierarchy Auto-Scoping:** ✅ IMPLEMENTED (`app/Services/Attendance/AttendanceService.php:496`). `attendance.approve_any` holders view all tenant requests; line managers view subordinate requests; standard users view own requests (non-self `user_uuid` throws 403 `INSUFFICIENT_SCOPE`).
* **Query Targeting:** Queries against linked `attendanceDay.attendance_date` ✅ IMPLEMENTED (`app/Services/Attendance/AttendanceService.php:540`).
* **Response Payload:** `AttendanceAdjustmentRequestResource` collection (Paginated) ✅ IMPLEMENTED.

### 3.6 `POST /api/v1/organization/attendance/adjustments`
* **Permission Required:** `attendance_adjustments.create` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:34`)
* **Request Body:** (`AdjustmentRequest.php`) ✅ IMPLEMENTED (`app/Http/Requests/Attendance/AdjustmentRequest.php:24`)
  * `attendance_day_uuid` (required, string, uuid)
  * `attendance_session_id` (optional, integer)
  * `adjustment_type` (required, integer, enum)
  * `requested_clock_in` (optional, date_format:Y-m-d H:i:s)
  * `requested_clock_out` (optional, date_format:Y-m-d H:i:s)
  * `reason` (required, string, max:500)
* **Response Payload:** `AttendanceAdjustmentRequestResource` ✅ IMPLEMENTED.

### 3.7 `PUT /api/v1/organization/attendance/adjustments/{uuid}/approve` & `/reject`
* **Permission Required:** `attendance.approve` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:35-36`)
* **Self-Approval Check:** Disallowed unconditionally via policy policy check.
* **Execution Flow:** Approving updates session/day clock times and re-executes `recalculateDay()`.

### 3.8 `GET /api/v1/organization/attendance/policy` & `PUT /api/v1/organization/attendance/policy`
* **Permission Required:** `attendance_policy.view` (GET) / `attendance_policy.manage` (PUT) ✅ IMPLEMENTED (`routes/api/v1/attendance.php:41-42`)
* **Response Payload:** `AttendancePolicyResource` ✅ IMPLEMENTED.

### 3.9 `GET /api/v1/organization/attendance/escalations`
* **Permission Required:** `attendance_escalations.view` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:65`)
* **Query Filters:** `user_uuid`, `status`, `escalation_type`, `per_page` ✅ IMPLEMENTED (`app/Http/Requests/Attendance/EscalationListRequest.php:24`).
* **Hierarchy Auto-Scoping:** ✅ IMPLEMENTED (`app/Services/Attendance/AttendanceService.php:570`).
* **Response Payload:** `AttendanceEscalationResource` collection (Paginated) ✅ IMPLEMENTED.

---

## 4. Business Logic & Calculation Engine

### Computation Pipeline (`AttendanceCalculationService::recalculateDay`)
1. **Policy Resolution:** Resolves tenant's active policy; returns uncomputed day if no policy exists.
2. **Session Aggregation:**
   * Total Work Minutes = `sum(clock_out_at - clock_in_at)` across closed sessions.
   * Total Break Minutes = `sum(next_clock_in - current_clock_out)` between sessions.
3. **Late Minutes Calculation:**
   * In **STRICT** mode: Compares first session `clock_in_at` against `shift_start_time + grace_late_minutes`. Late minutes = `clock_in_at - shift_start_time`.
   * In **FLEXIBLE** mode: Late minutes evaluation is bypassed.
4. **Overtime Calculation:** `overtime_minutes = max(0, total_work_minutes - required_daily_minutes)`.
5. **Status Determination Order:**
   * No sessions + Approved Leave → `LEAVE` (4)
   * No sessions + Active Holiday → `HOLIDAY` (5)
   * No sessions + Weekend → `WEEKEND` (6)
   * No sessions + Regular Working Day → `ABSENT` (2) / Compliance: `OVERDUE` (4)
   * Has Open Session today → `INCOMPLETE` (7) / Compliance: `PENDING` (2)
   * Work Minutes ≥ `required_daily_minutes` → `PRESENT` (1)
   * Work Minutes < `required_daily_minutes`: Evaluates `workDurationPenaltySlabs`. Deduction ≥ 100% → `ABSENT` (2) / Compliance: `PAYROLL_RISK` (3); Deduction ≥ 50% or Work Minutes ≥ 50% required → `HALF_DAY` (3).
6. **Late Penalty Compliance:** Monthly late count exceeding `allowed_monthly_late_count` escalates `compliance_status` to `PAYROLL_RISK` (3).

---

## 5. Resource Schemas

### `AttendanceDayResource` (`app/Http/Resources/Attendance/AttendanceDayResource.php`)
```json
{
  "uuid": "9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d4f11",
  "attendance_date": "2026-08-08",
  "attendance_status": 1,
  "attendance_status_label": "Present",
  "compliance_status": 1,
  "compliance_status_label": "Compliant",
  "total_work_minutes": 480,
  "total_break_minutes": 30,
  "late_minutes": 0,
  "overtime_minutes": 0,
  "total_sessions": 1,
  "user": {
    "uuid": "8f3b211a-4c2d-4e2b-91a1-3b4c5d6e7f8a",
    "name": "Jane Doe",
    "employee_code": "EMP-102",
    "avatar_url": null
  },
  "sessions": [],
  "policy_version": null,
  "created_at": "2026-08-08T08:00:00Z"
}
```

> **Data Audit:** All database migration fields are exposed. Identity `user` object key is injected into resource response.

---

## 6. Enum Reference Table

| Enum Class | Case Name | Value | Label | STATUS |
| :--- | :--- | :--- | :--- | :--- |
| `AttendanceStatusEnum` | `PRESENT` | 1 | Present | ✅ IMPLEMENTED (`app/Enums/AttendanceStatusEnum.php:12`) |
| | `ABSENT` | 2 | Absent | ✅ IMPLEMENTED |
| | `HALF_DAY` | 3 | Half Day | ✅ IMPLEMENTED |
| | `LEAVE` | 4 | On Leave | ✅ IMPLEMENTED |
| | `HOLIDAY` | 5 | Holiday | ✅ IMPLEMENTED |
| | `WEEKEND` | 6 | Weekend | ✅ IMPLEMENTED |
| | `INCOMPLETE` | 7 | Incomplete | ✅ IMPLEMENTED |
| `AttendanceComplianceStatusEnum` | `COMPLIANT` | 1 | Compliant | ✅ IMPLEMENTED (`app/Enums/AttendanceComplianceStatusEnum.php:12`) |
| | `PENDING` | 2 | Pending Verification | ✅ IMPLEMENTED |
| | `PAYROLL_RISK` | 3 | Payroll Risk | ✅ IMPLEMENTED |
| | `OVERDUE` | 4 | Overdue | ✅ IMPLEMENTED |
| `AttendanceModeEnum` | `STRICT` | 1 | Strict Shift | ✅ IMPLEMENTED (`app/Enums/AttendanceModeEnum.php:12`) |
| | `FLEXIBLE` | 2 | Flexible Hours | ✅ IMPLEMENTED |
| | `HYBRID` | 3 | Hybrid Mode | ✅ IMPLEMENTED |

---

## 7. Default Policy & Fallback Values

When no organization custom policy exists, `AttendancePolicyService::createDefaultPolicy()` generates fallback defaults (`app/Services/Attendance/AttendancePolicyService.php:42`):
* `attendance_mode`: `STRICT` (1)
* `shift_start_time`: `"09:00:00"`
* `shift_end_time`: `"18:00:00"`
* `grace_late_minutes`: `15`
* `required_daily_minutes`: `480` (8 hours)
* `half_day_min_minutes`: `240` (4 hours)
* `allowed_monthly_late_count`: `3`
* `geofence_enforced`: `false`

---

## 8. Known Gaps Summary

* **SECURITY**: None. Multi-tenant scoping and hierarchy access rules (`reports_to` → dept head fallback) are enforced across all service queries.
* **FUNCTIONAL**:
  * ❌ MISSING: `attendance.edit`, `attendance.delete`, `attendance.export`, and `attendance.import` permissions are seeded in `SystemPermission.php:49-54` but have no working routes or controllers.
* **COSMETIC**: None.
