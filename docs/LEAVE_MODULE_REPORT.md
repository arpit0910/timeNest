# Technical Audit Report: Leave Module

**Generated:** 2026-08-08  
**Scope:** `app/Http/Controllers/Api/V1/Organization/Leave/LeaveRequestController.php`, `LeaveController.php`, `LeavePolicyController.php`, `LeaveTypeController.php`, `LeaveRequestService.php`, `LeaveManagementService.php`, `EmployeeLeaveObserver.php`

---

## 1. Module Overview & Architecture

### Business Problem Solved
The Leave Module handles employee leave requests, leave accrual balances, custom leave policy definitions, multi-level approval workflows, cancellation limits, overlap detection, and automatic synchronization with daily attendance status.

### Entity Relationship Diagram
```
  ┌─────────────────┐       1:1       ┌──────────────────────┐
  │  Organization   │─────────────────│     LeavePolicy      │
  └─────────────────┘                 └──────────────────────┘
           │ 1:N                                 │ 1:N
           ▼                                     ▼
  ┌─────────────────┐                 ┌──────────────────────┐
  │    LeaveType    │                 │  LeavePolicyVersion  │
  └─────────────────┘                 └──────────────────────┘
           │ 1:N                                 │
           ├────────────────────────┐            │
           ▼                        ▼            ▼
  ┌──────────────────────┐    ┌──────────────────────────────┐
  │    LeaveBalance      │    │        EmployeeLeave         │
  └──────────────────────┘    └──────────────────────────────┘
                                             │ 1:N
                                             ▼
                              ┌──────────────────────────────┐
                              │     LeaveStatusHistory       │
                              └──────────────────────────────┘
```

---

## 2. Permissions & Authorization Matrix

| Permission Name | String Value | Frontend Scope | STATUS |
| :--- | :--- | :--- | :--- |
| `LEAVES_VIEW` | `leaves.view` | View personal and team leave requests | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:87`) |
| `LEAVES_CREATE` | `leaves.create` | Submit new leave application | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:88`) |
| `LEAVES_EDIT` | `leaves.edit` | Modify pending leave request | ❌ MISSING (seeded in enum line 89, no controller action) |
| `LEAVES_DELETE` | `leaves.delete` | Delete pending leave request | ❌ MISSING (seeded in enum line 90, no controller action) |
| `LEAVES_APPROVE` | `leaves.approve` | Approve/reject submitted leave requests | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:91`) |
| `LEAVES_APPROVE_ANY` | `leaves.approve_any` | Cross-department leave approval bypass | ⚠️ PARTIAL (defined in enum line 92, unused in `LeaveRequestService`) |
| `LEAVES_EXPORT` | `leaves.export` | Export leave history reports | ❌ MISSING (seeded in enum line 93, no controller action) |
| `LEAVE_POLICY_VIEW` | `leave_policy.view` | View active leave policy & leave types | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:67`) |
| `LEAVE_POLICY_MANAGE` | `leave_policy.manage` | Update leave policies & configure leave types | ✅ IMPLEMENTED (`app/Enums/SystemPermission.php:68`) |

> **Permission Discrepancy Note:** `LeaveRequestController::index` line 290 checks `$viewer->can('leave.request.view_all')`. This permission string is **NOT defined** in `SystemPermission.php` nor seeded by Spatie permission seeders. It must be updated to check `LEAVES_VIEW` or `LEAVES_APPROVE_ANY`.

---

## 3. Endpoint Specification

The codebase currently contains **TWO PARALLEL LEAVE ROUTE STRUCTURES**:
1. Main Leave Management API: `/api/v1/leave-requests` (powered by `LeaveRequestController`)
2. Attendance Sub-module API: `/api/v1/organization/attendance/leaves` (powered by `LeaveController`)

### 3.1 Main Leave API Endpoints (`/api/v1/leave-requests`)

#### 3.1.1 `GET /api/v1/leave-requests`
* **Permission Required:** Auth token (`auth:api`) + internal `can('leave.request.view_all')` check ⚠️ PARTIAL (`routes/api.php:100-111`)
* **Query Filters:**
  * `start_date` (optional, date, Y-m-d) — ✅ IMPLEMENTED (`LeaveRequestController.php:30`)
  * `end_date` (optional, date, Y-m-d, after_or_equal:start_date) — ✅ IMPLEMENTED
  * `leave_status` (optional, integer, enum) — ✅ IMPLEMENTED
  * `leave_type_id` (optional, string, uuid) — ✅ IMPLEMENTED
  * `user_id` / `user_uuid` (optional, string, uuid) — ✅ IMPLEMENTED
  * `per_page` (optional, integer, min:1, max:100, default:20) — ✅ IMPLEMENTED
* **Hierarchy Auto-Scoping:** ⚠️ PARTIAL. If user lacks `'leave.request.view_all'`, query is hard-scoped to `user_id == auth()->id()`. Manager hierarchy scoping is not integrated.
* **Response Payload:** `LeaveRequestResource` collection (Paginated) ✅ IMPLEMENTED (`app/Http/Resources/Leave/LeaveRequestResource.php`).

#### 3.1.2 `POST /api/v1/leave-requests`
* **Permission Required:** Auth token (`auth:api`) ✅ IMPLEMENTED
* **Request Body:** (`SubmitLeaveRequest.php`) ✅ IMPLEMENTED (`app/Http/Requests/Leave/SubmitLeaveRequest.php:24`)
  * `leave_type_id` (required, string, uuid)
  * `start_date` (required, date, format:Y-m-d)
  * `end_date` (required, date, format:Y-m-d, after_or_equal:start_date)
  * `is_half_day` (optional, boolean)
  * `reason` (required, string, max:1000)
  * `attachment_path` (optional, string)
* **Response Payload:** `LeaveRequestResource` ✅ IMPLEMENTED.

#### 3.1.3 `GET /api/v1/leave-requests/balances`
* **Permission Required:** Auth token (`auth:api`) ✅ IMPLEMENTED
* **Query Params:** `year` (optional, integer, default:current year)
* **Response Payload:** `LeaveBalanceResource` collection ✅ IMPLEMENTED (`app/Http/Resources/Leave/LeaveBalanceResource.php`).

#### 3.1.4 `POST /api/v1/leave-requests/{uuid}/approve`
* **Permission Required:** Auth token (`auth:api`) ✅ IMPLEMENTED
* **Request Body:** `remarks` (optional, string)
* **Self-Approval Check:** Enforcement present in `LeaveRequestService::approveLeave()` (`app/Services/Leave/LeaveRequestService.php:134`): throws `UnauthorizedLeaveActionException` if `approver->id === leave->user_id`.
* **Response Payload:** `LeaveRequestResource` ✅ IMPLEMENTED.

#### 3.1.5 `POST /api/v1/leave-requests/{uuid}/reject`
* **Permission Required:** Auth token (`auth:api`) ✅ IMPLEMENTED
* **Request Body:** `rejection_reason` (required, string, max:500)
* **Response Payload:** `LeaveRequestResource` ✅ IMPLEMENTED.

#### 3.1.6 `POST /api/v1/leave-requests/{uuid}/cancel`
* **Permission Required:** Auth token (`auth:api`) ✅ IMPLEMENTED
* **Request Body:** `reason` (required, string, max:500)
* **Response Payload:** `LeaveRequestResource` ✅ IMPLEMENTED.

---

### 3.2 Attendance Sub-Module Leave Endpoints (`/api/v1/organization/attendance/leaves`)

* `GET /api/v1/organization/attendance/leaves` — Middleware `permission:leaves.view` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:25`)
* `POST /api/v1/organization/attendance/leaves` — Middleware `permission:leaves.create` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:26`)
* `GET /api/v1/organization/attendance/leaves/{uuid}` — Middleware `permission:leaves.view` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:27`)
* `PATCH /api/v1/organization/attendance/leaves/{uuid}/status` — Middleware `permission:leaves.approve` ✅ IMPLEMENTED (`routes/api/v1/attendance.php:28`)

---

### 3.3 Leave Policy & Type Management Endpoints

* `GET /api/v1/leave/policy` & `PUT /api/v1/leave/policy` — Powered by `LeavePolicyController` (`routes/api.php:53-62`)
* `GET /api/v1/leave/policy/{policyUuid}/types` & `POST .../types` — Powered by `LeaveTypeController` (`routes/api.php:65-74`)

---

## 4. Business Logic & Calculation Engine

### 4.1 Leave Balance & Accrual Engine
* `findOrCreateBalance()` initializes annual balance from `LeaveType.annual_allocation_days`.
* `negative_balance_allowed`: If policy disables negative balances (`false`), submitting leave with `remaining_days - totalDays < 0` throws `InsufficientLeaveBalanceException` (`app/Services/Leave/LeaveRequestService.php:81`).
* Carry Forward: `carry_forward_days` tracked separately from `allocated_days`.

### 4.2 Days Calculation Engine
* `calculateLeaveDays()` iterates each day from `start_date` to `end_date`:
  * Checks `policyVersion.weekend_days` and `allow_leave_on_weekends`.
  * Checks `OrganizationHoliday` and `allow_leave_on_holidays`.
  * Increments total days count by 1.0 for valid working days.
* Half-day override sets `total_days = 0.5` (requires `start_date === end_date`).

### 4.3 Approval Hierarchy & Self-Approval Prevention
* Single Approval Flow: Manager approval sets status directly to `APPROVED` (2).
* Multi-Level Approval Flow: First level sets `approved_by` & `approved_at`; second level sets `second_approver_id` & status to `APPROVED` (2).
* **Self-Approval Prevention:** `if ($approver->id === $leave->user_id)` unconditionally throws `UnauthorizedLeaveActionException` (`app/Services/Leave/LeaveRequestService.php:134`).

### 4.4 Overlap Detection Engine
* `detectOverlap()` checks for active leaves (`PENDING`, `APPROVED`, `AUTO_APPROVED`) overlapping the range `[start_date, end_date]`.
* If found, throws `LeaveOverlapException` or `BusinessRuleViolationException('LEAVE_OVERLAP')`.

### 4.5 Cross-Module Link with Attendance Engine
* When `AttendanceCalculationService::recalculateDay` executes for a day with 0 sessions:
  * Checks `LeaveManagementService::hasApprovedLeave($userId, $dateStr)`.
  * If true (excluding WFH and Extra Working Day leave types), sets `AttendanceDay.attendance_status = LEAVE` (4).
* `EmployeeLeaveObserver` records all leave events into `AttendanceActivityLog` (`app/Observers/EmployeeLeaveObserver.php:20`).

---

## 5. Resource Schemas

### `LeaveRequestResource` (`app/Http/Resources/Leave/LeaveRequestResource.php`)
```json
{
  "uuid": "3c4d5e6f-7a8b-9c0d-1e2f-3a4b5c6d7e8f",
  "user": {
    "uuid": "8f3b211a-4c2d-4e2b-91a1-3b4c5d6e7f8a",
    "name": "Jane Doe",
    "email": "jane@example.com"
  },
  "leave_type": {
    "uuid": "11223344-5566-7788-9900-aabbccddeeff",
    "name": "Casual Leave",
    "code": "1",
    "color": "#3B82F6"
  },
  "leave_status": 2,
  "leave_status_label": "Approved",
  "start_date": "2026-08-10",
  "end_date": "2026-08-12",
  "total_days": 3.0,
  "reason": "Family obligation",
  "attachment_url": null,
  "approved_by": {
    "name": "John Smith"
  },
  "approved_at": "2026-08-08T09:00:00Z",
  "created_at": "2026-08-08T08:00:00Z"
}
```

---

## 6. Enum Reference Table

| Enum Class | Case Name | Value | Label | STATUS |
| :--- | :--- | :--- | :--- | :--- |
| `LeaveStatus` | `PENDING` | 1 | Pending | ✅ IMPLEMENTED (`app/Enums/Leave/LeaveStatus.php:12`) |
| | `APPROVED` | 2 | Approved | ✅ IMPLEMENTED |
| | `REJECTED` | 3 | Rejected | ✅ IMPLEMENTED |
| | `CANCELLED` | 4 | Cancelled | ✅ IMPLEMENTED |
| | `AUTO_APPROVED` | 5 | Auto Approved | ✅ IMPLEMENTED |
| `LeaveType` | `CASUAL` | 1 | Casual Leave | ✅ IMPLEMENTED (`app/Enums/Leave/LeaveType.php:9`) |
| | `SICK` | 2 | Sick Leave | ✅ IMPLEMENTED |
| | `PAID` | 3 | Paid Leave | ✅ IMPLEMENTED |
| | `UNPAID` | 4 | Unpaid Leave | ✅ IMPLEMENTED |
| | `WORK_FROM_HOME` | 5 | Work From Home | ✅ IMPLEMENTED |
| | `EXTRA_WORKING_DAY` | 6 | Extra Working Day | ✅ IMPLEMENTED |
| | `HALF_DAY` | 7 | Half Day Leave | ✅ IMPLEMENTED |
| | `EMERGENCY` | 8 | Emergency Leave | ✅ IMPLEMENTED |
| | `MATERNITY` | 9 | Maternity Leave | ✅ IMPLEMENTED |
| | `PATERNITY` | 10 | Paternity Leave | ✅ IMPLEMENTED |
| | `BEREAVEMENT` | 11 | Bereavement Leave | ✅ IMPLEMENTED |

---

## 7. Default Policy & Fallback Values

When initializing a Leave Policy, `LeavePolicyService` enforces fallback parameters:
* `approval_flow`: `SINGLE_APPROVAL` (1)
* `allow_leave_cancellation`: `true`
* `cancellation_before_hours`: `24`
* `negative_balance_allowed`: `false`
* `advance_notice_required_days`: `1`
* `max_advance_application_days`: `90`
* `document_required_after_days`: `3`

---

## 8. Known Gaps Summary

* **SECURITY**:
  * ⚠️ PARTIAL: Hierarchy scoping in `LeaveRequestController::index` is incomplete; non-admin query falls back to self-only listing without resolving subordinate employee hierarchy.
* **FUNCTIONAL**:
  * ❌ MISSING: Parallel endpoint mismatch! Two sets of routes exist (`/api/v1/leave-requests` vs `/api/v1/organization/attendance/leaves`). `LeaveRequestController` checks non-existent permission string `'leave.request.view_all'`.
  * ❌ MISSING: `leaves.edit`, `leaves.delete`, and `leaves.export` permissions are present in `SystemPermission.php` but have no corresponding controller methods.
* **COSMETIC**:
  * ⚠️ PARTIAL: `LeaveType` exists both as a DB model (`App\Models\Leave\LeaveType`) and a legacy enum (`App\Enums\Leave\LeaveType`).
