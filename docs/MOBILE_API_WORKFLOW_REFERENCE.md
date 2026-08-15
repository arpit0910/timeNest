# Mobile App API Workflow Reference

**Scope:** Attendance, Worklog, Leave modules, organized by user workflow (not by file/module) for mobile screen planning.

**Verification method:** every route was read from the live route files and cross-checked against `php artisan route:list --path=v1`. Every request/response contract was read directly from the current `FormRequest`/`Resource`/`Service` class.

Status tags: **✅ IMPLEMENTED** (works end-to-end) · **⚠️ PARTIAL** (reachable but has a real functional/security gap, or a sub-action is broken) · **❌ MISSING** (route exists but is currently non-functional for every caller) · **🔲 PLANNED ONLY** (no route/endpoint exists for this action at all).

The Leave module has two independently-working leave-request paths: `LeaveRequestController` at `/leave-requests/*`, and `LeaveController` at `/organization/attendance/leaves/*`. `LeaveRequestController` has the more complete/correct contract (proper balance finalization, multi-level approval support, a real approver queue with filters, a dedicated self-service cancel endpoint) and is documented as primary below; `LeaveController` is documented as the working-but-more-limited alternative.

---

## 1. CLOCK IN

**Status: ✅ IMPLEMENTED**

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance.create` (`SystemPermission::ATTENDANCE_CREATE`) | Anyone holding this permission | Self only |

Self-only action by design — no `user_uuid`/target-user field exists anywhere on the request or in the controller (`app/Http/Controllers/Api/V1/Organization/Attendance/AttendanceController.php:32-52` uses `auth()->user()` exclusively). Hierarchy scoping is not applicable here.

### B. Endpoint
`POST /api/v1/organization/attendance/clock-in` — `routes/api/v1/attendance.php:19`. Middleware: `permission:attendance.create` at the route level.

### C. Request body
`app/Http/Requests/Attendance/ClockInRequest.php:26-35`
| Field | Type | Required | Rules |
|---|---|---|---|
| `clock_in_source` | int (enum) | required | `Enum(AttendanceSessionSourceEnum)` — 1=MOBILE, 2=WEB, 3=ADMIN_PANEL, 4=SYSTEM |
| `clock_in_device_id` | string | optional | `max:255` |
| `clock_in_latitude` | numeric | required | `between:-90,90` |
| `clock_in_longitude` | numeric | required | `between:-180,180` |
| `clock_in_accuracy` | numeric | optional | `min:0` |

### D. Listing-specific
N/A — not a listing endpoint.

### E. Response shape
`AttendanceSessionResource` (`app/Http/Resources/Attendance/AttendanceSessionResource.php:19-52`), HTTP 201:
```json
{
  "uuid": "string",
  "clock_in_at": "datetime",
  "clock_out_at": "datetime|null",
  "clock_in_source": { "value": "int", "label": "string" },
  "clock_out_source": { "value": "int", "label": "string" },
  "clock_in_latitude": "numeric|null", "clock_in_longitude": "numeric|null",
  "clock_out_latitude": "numeric|null", "clock_out_longitude": "numeric|null",
  "is_suspicious": "bool",
  "suspicious_reason": "string|null",
  "duration_minutes": "int|null"
}
```

### F. State/validation rules
All in `AttendanceService::clockIn()` (`app/Services/Attendance/AttendanceService.php:66-207`):
- No employee profile for this org → `PROFILE_NOT_FOUND` (422).
- No attendance policy configured → `NO_POLICY_CONFIGURED` (422).
- An open session (no `clock_out_at`) already exists today → `ACTIVE_SESSION_EXISTS` (422).
- `policy.allow_multiple_sessions=false` and any session already exists today → `MULTIPLE_SESSIONS_BLOCKED` (422).
- Holiday, no `allow_clock_in_on_holidays` and no approved Extra-Working-Day leave → `HOLIDAY_CLOCK_IN_BLOCKED` (422).
- Weekend, no approved EWD leave → `WEEKEND_CLOCK_IN_BLOCKED` (422).
- Approved (non-WFH/non-EWD) leave exists on this date → `LeaveAttendanceConflictException` (422).
- Geofencing (skipped if approved WFH leave exists): no coordinates + `geo_fencing_enabled` → hard block under STRICT mode (`LOCATION_REQUIRED`), else flagged `is_suspicious`; coordinates outside the branch geofence (Haversine, 100m GPS-accuracy allowance, 200m default radius) → hard block under STRICT, flagged suspicious under FLEXIBLE/HYBRID.
- Day boundary resolved in the user's branch timezone (fallback user timezone, fallback UTC) — not server time.

---

## 2. CLOCK OUT

**Status: ✅ IMPLEMENTED**

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance.create` (same permission as clock-in — no separate `attendance.clock_out`) | Anyone holding this permission | Self only |

### B. Endpoint
`POST /api/v1/organization/attendance/clock-out` — `routes/api/v1/attendance.php:20`. Middleware: `permission:attendance.create`.

### C. Request body
`app/Http/Requests/Attendance/ClockOutRequest.php:26-35` (mirrors clock-in with `clock_out_` prefix):
| Field | Type | Required | Rules |
|---|---|---|---|
| `clock_out_source` | int (enum) | required | `Enum(AttendanceSessionSourceEnum)` |
| `clock_out_device_id` | string | optional | `max:255` |
| `clock_out_latitude` | numeric | required | `between:-90,90` |
| `clock_out_longitude` | numeric | required | `between:-180,180` |
| `clock_out_accuracy` | numeric | optional | `min:0` |

### D. Listing-specific
N/A.

### E. Response shape
Same `AttendanceSessionResource` as Clock In, HTTP 200.

### F. State/validation rules
`AttendanceService::clockOut()` (`app/Services/Attendance/AttendanceService.php:212-292`):
- No `AttendanceDay` row for today → `NO_CLOCK_IN_RECORD` (422).
- No open session → `NO_ACTIVE_SESSION` (422).
- Geofence check on clock-out is **flag-only, never blocking** — even in STRICT mode it only sets `is_suspicious`, never throws (skipped entirely if approved WFH leave exists).
- Triggers `AttendanceCalculationService::recalculateDay()` afterward (recomputes work/break/late/overtime minutes and day status).

---

## 3. VIEW TODAY'S ATTENDANCE (self + manager viewing a report)

**Status: ⚠️ PARTIAL** — works, but `approved_by_uuid` in the response is always `null` regardless of actual approval state (relation not wired).

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance.view` (self) | Any holder, no further scope needed | Self |
| `attendance.view` + hierarchy match | Holder who is the target's direct `reports_to` manager or their department's `head_user_id` | Direct reports / department members |
| `attendance.approve_any` or `platform.full_access` | Bypasses hierarchy entirely | Any user in the org |

Hierarchy auto-scoping is enforced in the service layer: `AttendanceService::getToday()` (`app/Services/Attendance/AttendanceService.php:484-508`) calls `canViewUser()` (`app/Policies/Concerns/ResolvesApprovalHierarchy.php:20-40`) whenever `user_uuid` targets someone other than self. A non-manager who passes another user's `user_uuid` gets a hard **403** (`CANNOT_VIEW_USER_ATTENDANCE`, `AuthorizationException`) — not silently ignored, not filtered to self.

### B. Endpoint
`GET /api/v1/organization/attendance/today` — `routes/api/v1/attendance.php:21`. Middleware: `permission:attendance.view`.

### C. Request body
N/A (GET). Query param: `user_uuid` (see A).

### D. Listing-specific
Single-record endpoint (not a real listing) — returns one `AttendanceDay` or `data: null` with message `"No clock-in record found for today."` if none exists.
- `user_uuid`: optional, `nullable|string|uuid|exists:users,uuid` (`app/Http/Requests/Attendance/AttendanceTodayRequest.php:19`), hierarchy-checked as above.
- No pagination, no sorting, no date filters (single day only, resolved as "today" in the target user's branch timezone).

### E. Response shape
`AttendanceDayResource` (`app/Http/Resources/Attendance/AttendanceDayResource.php:20-81`):
```json
{
  "uuid": "string",
  "user": { "uuid": "string", "name": "string", "employee_code": "string", "avatar_url": "string|null" },
  "attendance_date": "Y-m-d",
  "attendance_status": { "value": "int", "label": "string", "description": "string" },
  "compliance_status": { "value": "int", "label": "string", "description": "string" },
  "total_work_minutes": "int", "total_break_minutes": "int", "total_sessions": "int",
  "late_minutes": "int", "early_exit_minutes": "int", "overtime_minutes": "int",
  "approved_by_uuid": "always null — see gap below",
  "approved_at": "datetime|null",
  "policy_version": { "version_number": "int", "approval_flow": { "value": "int", "label": "string" } },
  "sessions": "AttendanceSessionResource[] (when loaded)",
  "created_at": "datetime", "updated_at": "datetime"
}
```

**Gap:** `approved_by_uuid` (`AttendanceDayResource.php:68`) reads `whenLoaded('approvedBy', ...)`, but the `AttendanceDay` model has no `approvedBy()` relation and it is never eager-loaded — this field will **always serialize as `null`**, even for approved days.

### F. State/validation rules
Read-only. Underlying aggregate computation is `AttendanceCalculationService::recalculateDay()` — see workflow 2F.

---

## 4. VIEW ATTENDANCE HISTORY (self + manager, all filters)

**Status: ⚠️ PARTIAL** — same `approved_by_uuid`-always-null gap as workflow 3, **plus** pagination metadata is computed server-side but dropped before reaching the client.

### A. Who can do this
Identical permission/hierarchy model to workflow 3 — same `canViewUser()` call, same 403 behavior for out-of-hierarchy `user_uuid` (`AttendanceService::getHistory()`, `app/Services/Attendance/AttendanceService.php:441-479`).

### B. Endpoint
`GET /api/v1/organization/attendance/history` — `routes/api/v1/attendance.php:22`. Middleware: `permission:attendance.view`.

### C. Request body
N/A (GET).

### D. Listing-specific
`AttendanceHistoryRequest::rules()` (`app/Http/Requests/Attendance/AttendanceHistoryRequest.php:26-34`):
| Param | Type | Filters against |
|---|---|---|
| `user_uuid` | uuid, `exists:users,uuid` | hierarchy-checked, see A |
| `start_date` (alias `from`) | date `Y-m-d` | `attendance_date >= X` (the day's own date column, **not** `created_at`) |
| `end_date` (alias `to`) | date `Y-m-d`, `after_or_equal:start_date` | `attendance_date <= X` |
| `status` | int, `in:1..7` (matches `AttendanceStatusEnum`) | `attendance_status = X` exact |
| `per_page` | int, `min:5,max:100` | default **30** |

- **Sorting:** no client-controlled `sort` param exists at all; hardcoded `orderBy('attendance_date', 'desc')`.
- **Pagination:** real `LengthAwarePaginator::paginate()` runs server-side, but the controller wraps it via the generic `success()` helper rather than the app's `paginated()` helper (`app/Traits/ApiResponse.php:97-111`, which is never called by any attendance controller) — **the response `meta` is hardcoded `null`**, so `current_page`/`last_page`/`total` are silently dropped. `?page=N` still works, it's just undocumented and the client can't detect when it's run out of pages except by getting an empty `data` array.

### E. Response shape
Array of `AttendanceDayResource` — same shape as workflow 3E, including the `approved_by_uuid` gap.

### F. State/validation rules
Read-only.

---

## 5. VIEW / MANAGE ATTENDANCE POLICY (including `versions()`)

**Status: ✅ IMPLEMENTED** at `api/v1/organization/attendance/policy`.

A second, legacy path also exists and is reachable: `api/v1/attendance/policy[/{uuid}][/versions]` (`routes/api/v1/attendance.php:53-62`, controller `App\Http\Controllers\Api\Attendance\AttendancePolicyController`). It uses the **same** underlying `AttendancePolicyService`/`AttendancePolicyResource` as the org-scoped controller below — not a divergent data store — but exposes `store`/`index`/`{uuid}` CRUD semantics (no auto-provisioning; you must `POST` to create a policy first) instead of the org-scoped controller's auto-create-on-first-access behavior. **Recommend the org-scoped path below** for a simpler mobile contract (no explicit create step needed) — the legacy one is a valid parallel option, not a dead end.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance_policy.view` | Any holder | Org-wide singleton policy (read) |
| `attendance_policy.manage` | Any holder | Org-wide singleton policy (write) |

No hierarchy concept applies — this is a single record per organization, flat permission gate only, no `user_uuid`.

### B. Endpoint(s)
All under `routes/api/v1/attendance.php:34-38`, controller `App\Http\Controllers\Api\V1\Organization\Attendance\AttendancePolicyController`:
- `GET /api/v1/organization/attendance/policy` (`show`) — `permission:attendance_policy.view`
- `PUT /api/v1/organization/attendance/policy` (`update`) — `permission:attendance_policy.manage`
- `GET /api/v1/organization/attendance/policy/versions` (`versions`) — `permission:attendance_policy.view`

### C. Request body (update only)
`UpdateAttendancePolicyRequest::rules()` (`app/Http/Requests/Attendance/UpdateAttendancePolicyRequest.php:27-63`) — this is the class the live controller actually uses (`CreateAttendancePolicyRequest` and `UpdatePolicyRequest` are dead files, unused by any live controller). All fields `sometimes` (partial update):

| Field | Type | Rules |
|---|---|---|
| `attendance_mode` | int enum | `Enum(AttendanceModeEnum)` — 1=STRICT,2=FLEXIBLE,3=HYBRID |
| `approval_flow` | int enum | `Enum(ApprovalFlowEnum)` — 1=AUTO,2=SINGLE_APPROVAL,3=MULTI_LEVEL_APPROVAL |
| `shift_start_time`, `shift_end_time` | string | `date_format:H:i:s` |
| `required_daily_minutes` | int | `min:1,max:1440` |
| `minimum_session_minutes` | int | `min:1,max:1440` |
| `grace_late_minutes` | int | `min:0,max:120` |
| `allowed_monthly_late_count` | int | `min:0,max:31` |
| `allow_early_exit` | bool | — |
| `grace_early_exit_minutes` | int | `required_if:allow_early_exit,true`, `min:0,max:120` |
| `default_break_minutes` | int | `min:0,max:480` |
| `max_break_minutes` | int | `min:0,max:480` |
| `allow_multiple_sessions` | bool | — |
| `allow_clock_in_on_holidays` | bool | — |
| `auto_clock_out_enabled` | bool | — |
| `auto_clock_out_after_minutes` | int | `required_if:auto_clock_out_enabled,true`, `min:30,max:1440` |
| `overtime_enabled` | bool | — |
| `overtime_starts_after_minutes` | int | `required_if:overtime_enabled,true`, `min:1,max:1440` |
| `max_daily_overtime_minutes` | int | `nullable`, `min:0,max:480` (always-optional, not gated by `overtime_enabled`) |
| `overtime_requires_approval` | bool | `required_if:overtime_enabled,true` |
| `weekend_days` | array | `min:1`; each item int `in:1..7` |
| `geo_fencing_enabled` | bool | — |
| `geo_fence_radius_meters` | int | `required_if:geo_fencing_enabled,true`, `min:50,max:50000` |
| `ip_restriction_enabled` | bool | — |
| `strict_worklog_enforcement` | bool | — |
| `late_penalty_slabs` | array | each: `late_count_threshold` int `min:1,max:31`; `deduction_percentage` numeric `min:0.01,max:100` |
| `work_duration_penalty_slabs` | array | each: `min_work_minutes` int `min:0`; `max_work_minutes` int `min:1`; `deduction_percentage` numeric `min:0.01,max:100` |

No uuid-reference fields on this request (org-scoped singleton config).

### D. Listing-specific (`versions`)
`AttendancePolicyService::getPolicyVersions()` — plain `Collection`, **not paginated**, no filters, no `per_page`, hardcoded `orderBy('version', 'desc')`.

### E. Response shape
`show`/`update` → `AttendancePolicyResource` (`app/Http/Resources/Attendance/AttendancePolicyResource.php:19-73`):
```json
{
  "uuid": "string", "organization_id": "actually the org's UUID string, misleadingly named",
  "attendance_mode": { "value": "int", "label": "string", "description": "string" },
  "approval_flow": { "value": "int", "label": "string", "description": "string", "requires_approver": "bool", "requires_second_approver": "bool" },
  "shift_start_time": "H:i:s", "shift_end_time": "H:i:s",
  "required_daily_minutes": "int", "minimum_session_minutes": "int",
  "grace_late_minutes": "int", "allowed_monthly_late_count": "int",
  "allow_early_exit": "bool", "grace_early_exit_minutes": "int",
  "default_break_minutes": "int", "max_break_minutes": "int",
  "allow_multiple_sessions": "bool", "allow_clock_in_on_holidays": "bool",
  "auto_clock_out_enabled": "bool", "auto_clock_out_after_minutes": "int",
  "overtime_enabled": "bool", "overtime_starts_after_minutes": "int",
  "max_daily_overtime_minutes": "int|null", "overtime_requires_approval": "bool",
  "weekend_days": "int[]",
  "geo_fencing_enabled": "bool", "geo_fence_radius_meters": "int",
  "ip_restriction_enabled": "bool", "strict_worklog_enforcement": "bool",
  "current_version": "int",
  "late_penalty_slabs": [{ "uuid": "string", "late_count_threshold": "int", "deduction_percentage": "numeric" }],
  "work_duration_penalty_slabs": [{ "uuid": "string", "min_work_minutes": "int", "max_work_minutes": "int", "deduction_percentage": "numeric" }],
  "created_at": "datetime", "updated_at": "datetime"
}
```
`versions` → `AttendancePolicyVersionResource::collection()` (`app/Http/Resources/Attendance/AttendancePolicyVersionResource.php:18-63`): same field set minus the two slab arrays, plus `id` (**this is the version number, not a row id — deliberately aliased**, per the class's own comment), `version`, `attendance_policy_uuid`, `created_by_uuid`. Not paginated.

### F. State/validation rules
- `show`/`update` auto-create a default policy on first access — the org can never get a 404 "no policy" from either endpoint.
- Every `update` creates a new immutable version row (`max(version)+1`, row-locked to avoid races) — **even a no-op update produces a new version.**
- `late_penalty_slabs` thresholds must be unique; `work_duration_penalty_slabs` ranges must not overlap (`max(minA,minB) <= min(maxA,maxB)` triggers `InvalidPenaltySlabException`).
- If `late_penalty_slabs`/`work_duration_penalty_slabs` keys are present in the payload, **all existing slabs of that type are deleted and replaced** — there is no partial/incremental slab update.

---

## 6. SUBMIT ATTENDANCE ADJUSTMENT

**Status: ⚠️ PARTIAL** — works, but there is no ownership check preventing an adjustment being submitted against a day that isn't the requester's own, and the response never surfaces who submitted it.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance_adjustments.create` | Any holder | Nominally self, but **not enforced** — see gap |

Self-submission is the intended model (`requested_by = auth()->user()->id` always), and no `user_uuid` field exists on the request. **Gap:** the target `attendance_day_uuid` is only checked against `organization_id` (`AttendanceAdjustmentController.php:51-53`), **not** against the caller's own `user_id` — any holder of `attendance_adjustments.create` can submit an adjustment against any other employee's attendance day in the org, and it will be recorded as though they requested it themselves.

### B. Endpoint
`POST /api/v1/organization/attendance/adjustments` — `routes/api/v1/attendance.php:28`. Middleware: `permission:attendance_adjustments.create`.

### C. Request body
`AdjustmentRequest::rules()` (`app/Http/Requests/Attendance/AdjustmentRequest.php:20-30`):
| Field | Type | Required | Rules |
|---|---|---|---|
| `attendance_day_uuid` | uuid | required | `exists:attendance_days,uuid` |
| `attendance_session_uuid` | uuid | optional | `exists:attendance_sessions,uuid`; service verifies it belongs to the given day |
| `adjustment_type` | int enum | required | `Enum(AttendanceAdjustmentTypeEnum)` — 1=CLOCK_IN_CORRECTION, 2=CLOCK_OUT_CORRECTION, 3=SESSION_DELETION, 4=MANUAL_ATTENDANCE |
| `clock_in_at` | date | optional | — |
| `clock_out_at` | date | optional | `after_or_equal:clock_in_at` |
| `reason` | string | required | `max:500` |

### D. Listing-specific
N/A (see workflow 7 for listing).

### E. Response shape
`AttendanceAdjustmentRequestResource` (`app/Http/Resources/Attendance/AttendanceAdjustmentRequestResource.php:12-35`), HTTP 201:
```json
{
  "uuid": "string", "attendance_day_uuid": "string", "attendance_session_uuid": "string|null",
  "adjustment_type": { "value": "int", "label": "string", "color": "string" },
  "status": { "value": "int", "label": "string", "color": "string" },
  "details": { "clock_in_at": "..", "clock_out_at": "..", "reason": ".." },
  "rejection_reason": "string|null", "resolved_at": "datetime|null", "created_at": "datetime"
}
```
**Gap:** no requester identity (`requested_by`) is exposed anywhere in this resource, even though it's eager-loaded server-side — an approver reviewing the list cannot tell who submitted each adjustment from the API response alone.

### F. State/validation rules
`AttendanceService::submitAdjustment()` (`app/Services/Attendance/AttendanceService.php:297-343`):
- Approved (non-WFH/non-EWD) leave covering the target day's date blocks submission → `LeaveAttendanceConflictException` (422).
- Session uuid, if given, must belong to the target day → `INVALID_SESSION_DAY` (422).
- Always created as `status = PENDING` — no duplicate-pending check (multiple pending adjustments per day are allowed).

---

## 7. VIEW ADJUSTMENTS (self + as approver)

**Status: ⚠️ PARTIAL** — hierarchy scoping works correctly; pagination metadata is dropped (same pattern as workflow 4).

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance_adjustments.view`, no `attendance.approve`/`approve_any` | Holder | Self only — passing another `user_uuid` → 403 `INSUFFICIENT_SCOPE` |
| `attendance.approve` (note: NOT `attendance_adjustments.view` — see note) | Holder | Self + subordinates (`reports_to` direct reports + department members where holder is `head_user_id`) |
| `attendance.approve_any` or `platform.full_access` | Holder | Org-wide, no hierarchy check even on the `user_uuid` filter |

All scoping is done inline in `AttendanceService::getAdjustments()` (`app/Services/Attendance/AttendanceService.php:513-584`) — **not** via a Policy class. Note the asymmetry: the "see subordinates" tier is gated on `attendance.approve`, not on `attendance_adjustments.view` itself.

### B. Endpoint
`GET /api/v1/organization/attendance/adjustments` — `routes/api/v1/attendance.php:27`. Middleware: `permission:attendance_adjustments.view`.

### C. Request body
N/A (GET).

### D. Listing-specific
`AdjustmentListRequest::rules()` (`app/Http/Requests/Attendance/AdjustmentListRequest.php:16-27`):
| Param | Type | Filters against |
|---|---|---|
| `status` | int, `in:1,2,3,4` (PENDING/APPROVED/REJECTED/CANCELLED) | `status = X` exact |
| `adjustment_type` | int, `in:1,2,3,4` | `adjustment_type = X` exact |
| `user_uuid` | uuid, `exists:users,uuid` | `requested_by`, hierarchy-checked per A |
| `start_date`/`from`, `end_date`/`to` | date `Y-m-d` | **`attendanceDay.attendance_date`** via `whereHas` — not the adjustment's own `created_at` |
| `per_page` | int, `min:5,max:100` | default 30 |

No `sort` param; hardcoded `orderBy('created_at', 'desc')`. Paginated server-side but response `meta` is dropped (same gap as workflow 4).

### E. Response shape
Array of `AttendanceAdjustmentRequestResource` — same shape as workflow 6E, same missing-requester-identity gap.

### F. State/validation rules
Read-only.

---

## 8. APPROVE / REJECT ADJUSTMENT

**Status: ✅ IMPLEMENTED** — hierarchy correctly enforced via a real Policy class.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance.approve` (no separate `attendance_adjustments.approve` exists; route accepts this OR `approve_any`) | Holder who is the target's direct manager or dept head | Direct reports / department members — **never self**, even with `approve_any` |
| `attendance.approve_any` or `platform.full_access` | Bypasses hierarchy | Any user in the org (still never self) |

The permission gate lives in route middleware; `AttendanceAdjustmentPolicy::approve()` (`app/Policies/AttendanceAdjustmentPolicy.php:43-63`) decides the hierarchy scoping, invoked explicitly (`$this->authorize('approve', $adjustment)`).

### B. Endpoint(s)
- `PUT /api/v1/organization/attendance/adjustments/{uuid}/approve` — `routes/api/v1/attendance.php:30`, `permission:attendance.approve|attendance.approve_any`
- `PUT /api/v1/organization/attendance/adjustments/{uuid}/reject` — `routes/api/v1/attendance.php:31`, `permission:attendance.approve|attendance.approve_any`

### C. Request body
- Approve: **no body accepted** — controller method takes no request param at all.
- Reject: validated inline in the controller: `reason` — required, string, `max:255` (different cap than the original submission's `reason`, which allows `max:500`).

### D. Listing-specific
N/A.

### E. Response shape
`AttendanceAdjustmentRequestResource` (workflow 6E), HTTP 200.

### F. State/validation rules
- Must currently be `PENDING`, else `ADJUSTMENT_ALREADY_PROCESSED` (422).
- Approve applies the correction per `adjustment_type`; MANUAL_ATTENDANCE creates a new session; SESSION_DELETION removes one; CLOCK_IN/OUT corrections require the linked session to exist.
- Approve triggers `AttendanceCalculationService::recalculateDay()` afterward; reject does not.

---

## 9. VIEW ESCALATIONS (self + as resolver)

**Status: ⚠️ PARTIAL** — list is correctly hierarchy-scoped; the single-record `show` endpoint is **not**, letting any holder of the view permission read any employee's individual escalation by UUID.

### A. Who can do this
**List** (`index`): same three-tier pattern as adjustments — `attendance_escalations.resolve`/`platform.full_access` see everyone; `attendance_escalations.view` alone is scoped to self + subordinates (403 `CANNOT_VIEW_USER_ATTENDANCE` outside that set); no permission → self only.

**Show single record**: gated by `AttendanceEscalationPolicy::view()` (`app/Policies/AttendanceEscalationPolicy.php:16-23`), which — unlike every other Attendance/Worklog policy — **does not use `ResolvesApprovalHierarchy` at all**. Flat same-org + permission check only.

| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance_escalations.view` (list) | Holder | Self + subordinates only |
| `attendance_escalations.view` (show by uuid) | Holder | **Anyone in the org — hierarchy not checked (gap)** |
| `attendance_escalations.resolve` / `platform.full_access` | Holder | Org-wide |

### B. Endpoint(s)
- `GET /api/v1/organization/attendance/escalations` — `routes/api/v1/attendance.php:42`, `permission:attendance_escalations.view`
- `GET /api/v1/organization/attendance/escalations/{uuid}` — `routes/api/v1/attendance.php:43`, `permission:attendance_escalations.view`

### C. Request body
N/A (GET).

### D. Listing-specific
`EscalationListRequest::rules()` (`app/Http/Requests/Attendance/EscalationListRequest.php:16-24`):
| Param | Type | Filters against |
|---|---|---|
| `status` | int, `in:1,2,3` (PENDING/RESOLVED/DISMISSED) | `escalation_status = X` exact |
| `escalation_type` | int, `in:1..6` | `escalation_type = X` exact |
| `user_uuid` | uuid, `exists:users,uuid` | hierarchy-checked per A |
| `per_page` | int, `min:5,max:100` | default 30 |

**No date-range filter exists at all**. No `sort` param; hardcoded `orderBy('created_at', 'desc')`. Paginated server-side, response `meta` dropped.

### E. Response shape
`AttendanceEscalationResource` (`app/Http/Resources/Attendance/AttendanceEscalationResource.php:12-37`):
```json
{
  "uuid": "string", "organization_uuid": "string", "user_uuid": "string",
  "attendance_day_uuid": "string|null", "attendance_worklog_uuid": "string|null",
  "escalation_type": { "value": "int", "label": "string" },
  "escalation_level": "int",
  "escalation_status": { "value": "int", "label": "string" },
  "remarks": "string|null", "metadata": "object|null",
  "resolved_by": "raw numeric user id, NOT a uuid — see note",
  "resolved_at": "datetime|null", "created_at": "datetime"
}
```
**Inconsistency:** `resolved_by` is the raw internal numeric FK, not a uuid — every other identity reference in this resource is a uuid.

### F. State/validation rules
Read-only — escalations are system-generated, not created via any endpoint in this document.

---

## 10. RESOLVE / DISMISS ESCALATION

**Status: ⚠️ PARTIAL** — works, but has no hierarchy check at all, and an out-of-range `status` value causes an unhandled 500.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `attendance_escalations.resolve` | Any holder | **Any employee in the org — no hierarchy check (gap)** |

`AttendanceEscalationPolicy::resolve()` (`app/Policies/AttendanceEscalationPolicy.php:25-32`) is a flat same-org + permission check — no self-block, no dept-head/reports-to restriction. Inconsistent with adjustment-approve and worklog-approve, which both enforce hierarchy.

### B. Endpoint
`PATCH /api/v1/organization/attendance/escalations/{uuid}/status` — `routes/api/v1/attendance.php:44`. Middleware: `permission:attendance_escalations.resolve`.

### C. Request body
`UpdateAttendanceEscalationStatusRequest::rules()` (`app/Http/Requests/Attendance/UpdateAttendanceEscalationStatusRequest.php:18-23`):
| Field | Type | Required | Rules |
|---|---|---|---|
| `status` | int | required | **no `in:` constraint** — any integer passes FormRequest validation |
| `remarks` | string | optional | no length cap |

**Bug:** the controller resolves the enum via `EscalationStatusEnum::from((int)$validated['status'])`, which **throws an uncaught `\ValueError` (500)** for any value outside `{1,2,3}`. Only `status=3` (DISMISSED) is actually checked for; anything else falls through to the resolve branch regardless of intent.

### D. Listing-specific
N/A.

### E. Response shape
`AttendanceEscalationResource` (workflow 9E), HTTP 200.

### F. State/validation rules
- Must currently be `PENDING`, else `ESCALATION_ALREADY_FINALIZED` (422).
- Sets `escalation_status`, `resolved_by`, `resolved_at`, `remarks`. No side effects on the underlying `AttendanceDay`/`AttendanceWorklog`.

---

## 11. SUBMIT WORKLOG

**Status: ✅ IMPLEMENTED** — the uuid-conversion is complete and enforced: legacy raw-id fields are hard-rejected with 422, not silently dropped.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `worklog.create` | Any holder | Self only (`user_id` always set from the caller; no target-user field exists) |

No hierarchy concern — the day-ownership check (`day.user_id !== caller.id` → `INVALID_ATTENDANCE_OWNER`, 422) makes this inherently self-scoped.

### B. Endpoint
`POST /api/v1/organization/attendance/days/{dayUuid}/worklogs` (`storeForDay`) — `routes/api/v1/worklogs.php:24`. Middleware: `permission:worklog.create`.

### C. Request body
`StoreAttendanceWorklogRequest::rules()` (`app/Http/Requests/Attendance/StoreAttendanceWorklogRequest.php:39-68`). `attendance_day_uuid` is auto-injected from the route param — **do not send it in the body.**
| Field | Type | Required | Rules |
|---|---|---|---|
| `attendance_session_uuid` | uuid | optional | `exists:attendance_sessions,uuid` |
| `project_uuid` | uuid | optional | `exists:projects,uuid` |
| `milestone_uuid` | uuid | optional | `exists:milestones,uuid` |
| `task_uuid` | uuid | optional | `exists:tasks,uuid` |
| `attendance_session_id`, `project_id`, `milestone_id`, `task_id` | — | **`prohibited`** | 422 if sent, with message e.g. `"project_id is deprecated; use project_uuid instead."` |
| `start_time` | datetime | optional | `date_format:Y-m-d H:i:s`, `after_or_equal:` (today−15 days, org tz), `before_or_equal:` end of today |
| `end_time` | datetime | optional | `date_format:Y-m-d H:i:s`, `after:start_time`, `before_or_equal:` end of today |
| `logged_minutes` | int | optional | `min:0` |
| `description` | string | optional | — |
| `justification` | string | optional | — |
| `metadata` | array | optional | — |

Every relational field is uuid-string-only; legacy int-id counterparts are hard 422-rejected (not silently dropped).

### D. Listing-specific
N/A.

### E. Response shape
`AttendanceWorklogResource` — see workflow 13E, HTTP 201.

### F. State/validation rules
All in `AttendanceWorklogValidationService`/`CreateAttendanceWorklogAction`:
- Day must belong to the submitting user (`INVALID_ATTENDANCE_OWNER`, 422).
- Session, if given, must belong to the same day (`INVALID_SESSION_DAY`, 422).
- Submission window: blocked once `lock_after_days` policy threshold has passed (`WORKLOG_LOCKED`, 422).
- Policy-driven required mappings: `require_project_mapping`/`require_task_mapping` make `project_id`/`task_id` required (422).
- Task/milestone/project hierarchy must be internally consistent; caller must be a member of the project (`PROJECT_ACCESS_DENIED`, 422 otherwise).
- Task overflow requires `justification` if policy demands it → `WORKLOG_OVERFLOW_JUSTIFICATION_REQUIRED` (422).
- `require_description` policy: description required, must meet `min_description_length` → `WORKLOG_DESCRIPTION_REQUIRED` (422).
- Session overflow triggers the same overflow-justification exception.
- Duplicate-per-session: blocked unless `allow_multiple_worklogs_per_session` → `WORKLOG_ALREADY_EXISTS_FOR_SESSION` (409).
- Overlap with any existing worklog time window → `OVERLAPPING_WORKLOG_TIME` (422).
- Initial status: `AUTO_APPROVED` if policy's approval flow is AUTO, else `SUBMITTED` (never starts as `DRAFT`).
- ⚠️ **Known bug:** `compliance_status` is written using one enum but read back through a *different* enum with overlapping int values but different meanings — the label shown can be wrong whenever a task-overflow occurred. Not fixable client-side.

---

## 12. EDIT / DELETE WORKLOG

**Status: ⚠️ PARTIAL** — `DELETE` works; **`PUT` (update) currently throws an uncaught `ArgumentCountError` and will 500 on every call.**

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `worklog.create` (reused — no separate `worklog.edit` permission) | Any holder | **Owner only, hardcoded** — no manager/`worklog.approve_any`/`platform.full_access` override exists |

Both `update()` and `destroy()` skip the Policy layer entirely and use a raw inline check: non-owner gets `"Cannot update someone else's worklog."` (422, not 403).

### B. Endpoint(s)
- `PUT /api/v1/organization/attendance/worklogs/{uuid}` (`update`) — `routes/api/v1/worklogs.php:28`, `permission:worklog.create` — **⚠️ currently broken: `UpdateAttendanceWorklogAction` calls `WorklogPolicyService::getWorklogPolicyForOrganization()` with 1 argument where 2 are required, producing an uncaught `ArgumentCountError` (500) on every call.** Do not build the edit screen against this until fixed server-side.
- `DELETE /api/v1/organization/attendance/worklogs/{uuid}` (`destroy`) — `routes/api/v1/worklogs.php:29`, `permission:worklog.create` — working.

### C. Request body
`UpdateAttendanceWorklogRequest::rules()` (`app/Http/Requests/Attendance/UpdateAttendanceWorklogRequest.php:18-35`):
| Field | Type | Required | Rules |
|---|---|---|---|
| `project_uuid` | uuid | sometimes/nullable | `exists:projects,uuid` |
| `milestone_uuid` | uuid | sometimes/nullable | `exists:milestones,uuid` |
| `task_uuid` | uuid | sometimes/nullable | `exists:tasks,uuid` |
| `project_id`, `milestone_id`, `task_id` | — | **`prohibited`** | 422 deprecation message (no session field on update at all — immutable after creation) |
| `start_time` | datetime | sometimes/nullable | `date_format:Y-m-d H:i:s` (no 15-day-window re-check, unlike store) |
| `end_time` | datetime | sometimes/nullable | `date_format:Y-m-d H:i:s`, `after:start_time` |
| `logged_minutes` | int | sometimes/nullable | `min:0` |
| `description`, `justification` | string | sometimes/nullable | — |
| `metadata` | array | sometimes/nullable | — |

DELETE: no body.

### D. Listing-specific
N/A.

### E. Response shape
`AttendanceWorklogResource` (workflow 13E). DELETE returns `data: null`, message `"Worklog deleted successfully."`.

### F. State/validation rules
- Blocked entirely if the worklog is `APPROVED` or `LOCKED` → `WORKLOG_LOCKED` (422), for both update and delete.
- Update re-runs the full submission validation (workflow 11F), excluding the record itself from overlap/overflow checks.
- `metadata` on update is **merged** with the existing value, not replaced.
- Delete is a **soft delete** — recoverable server-side, not gone from the DB.

---

## 13. VIEW WORKLOGS (self + as approver, all filters)

**Status: ⚠️ PARTIAL** — `GET worklogs` (index) has **no hierarchy scoping at all**. `GET worklogs/{uuid}` (show) correctly enforces hierarchy. `GET days/{dayUuid}/worklogs` (forDay) checks attendance-day hierarchy, not worklog hierarchy specifically.

### A. Who can do this
| Endpoint | Permission required | Actual scope |
|---|---|---|
| `index` (`GET worklogs`) | `worklog.view` | **Everyone who can reach the route can see ALL org worklogs** — the intended self/approver/approve_any tiering is dead code because holding the route's own required permission already satisfies the "can view all" condition. Optional `user_uuid` filter has **no ownership/hierarchy check**. |
| `show` (`GET worklogs/{uuid}`) | `worklog.view` | Self always OK; else requires `worklog.view` **and** hierarchy match via `AttendanceWorklogPolicy::view()`; `worklog.approve_any`/`platform.full_access` bypasses hierarchy |
| `forDay` (`GET days/{dayUuid}/worklogs`) | `worklog.view` | Gated by attendance-day hierarchy check against `attendance.view`/`attendance.approve` (a **different** permission from `worklog.view`), then a `worklog.view`/`worklog.approve` all-or-nothing flag with no further per-worklog hierarchy check |

**Mobile guidance:** passing another user's `user_uuid` on `index` today works for **any** `worklog.view` holder — a real scoping gap the backend needs to fix, not something the mobile client can compensate for.

### B. Endpoint(s)
- `GET /api/v1/organization/attendance/days/{dayUuid}/worklogs` (`forDay`) — `routes/api/v1/worklogs.php:25`, `permission:worklog.view`
- `GET /api/v1/organization/attendance/worklogs` (`index`) — `routes/api/v1/worklogs.php:26`, `permission:worklog.view`
- `GET /api/v1/organization/attendance/worklogs/{uuid}` (`show`) — `routes/api/v1/worklogs.php:27`, `permission:worklog.view`

### C. Request body
N/A (GET).

### D. Listing-specific
`WorklogListRequest::rules()` (`app/Http/Requests/Attendance/WorklogListRequest.php:16-25`) — applies to `index` only; `forDay` takes a plain unvalidated `Request` with no filters/pagination at all.
| Param | Type | Filters against |
|---|---|---|
| `user_uuid` | uuid, `exists:users,uuid` | `user_id` — **not hierarchy-checked** |
| `status` | int, `in:1..6` (DRAFT/SUBMITTED/APPROVED/REJECTED/AUTO_APPROVED/LOCKED) | `worklog_status` column, exact |
| `from` / `to` (also accepts unvalidated aliases `start_date`/`end_date`) | date `Y-m-d` | **`attendanceDay.attendance_date`** — NOT the worklog's own `created_at`/`start_time` |
| `per_page` | int, `min:5,max:100` | default **30** |

- **Sorting:** `index` hardcoded `orderBy('created_at', 'desc')`; `forDay` hardcoded `orderBy('created_at', 'asc')` — opposite direction, no client control either way.
- **Pagination:** `index` uses real `paginate($perPage)` but meta is dropped. `forDay` returns a full unpaginated array — no `per_page` accepted at all.

### E. Response shape
`AttendanceWorklogResource` (`app/Http/Resources/Attendance/AttendanceWorklogResource.php:12-63`):
```json
{
  "uuid": "string", "organization_uuid": "string|null", "user_uuid": "string|null",
  "attendance_day_uuid": "string|null", "attendance_session_uuid": "string|null",
  "project": { "uuid": "string", "name": "string" } | null,
  "milestone": { "uuid": "string", "name": "string" } | null,
  "task": { "uuid": "string", "name": "string", "estimated_minutes": "int" } | null,
  "worklog_status": { "value": "int", "label": "string", "color": "string" },
  "compliance_status": { "value": "int", "label": "string" },
  "start_time": "Y-m-d H:i:s|null", "end_time": "Y-m-d H:i:s|null",
  "logged_minutes": "int",
  "description": "string|null", "justification": "string|null",
  "submitted_at": "datetime|null", "approved_at": "datetime|null", "rejected_at": "datetime|null",
  "rejection_reason": "string|null", "metadata": "object|null",
  "status_histories": [{ "old_status": "int|null", "new_status": "int|null", "remarks": "string|null", "created_at": "datetime|null" }]
}
```
Note: the richer standalone `WorklogStatusHistoryResource` (`{value,label}` pairs + `changed_by`) exists but is **not actually used anywhere** in this module's live endpoints.

### F. State/validation rules
Read-only.

---

## 14. APPROVE / REJECT WORKLOG

**Status: ✅ IMPLEMENTED** for the live endpoint contract — hierarchy is correctly enforced. Note the actual live validation is inline in the controller, not the `ApproveWorklogRequest`/`RejectWorklogRequest` classes (which exist but are unused/dead — do not trust their rules as the contract).

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `worklog.approve` (route accepts this OR `approve_any`) | Holder who is the target's direct manager or dept head | Direct reports / department members — never self |
| `worklog.approve_any` | Bypasses hierarchy | Any user in the org — still never self |

The permission gate lives in route middleware; `$this->authorize('approve', $worklog)` → `AttendanceWorklogPolicy::approve()` decides the hierarchy scoping, same `withinApprovalHierarchy()` pattern as Attendance adjustments.

### B. Endpoint(s)
- `POST /api/v1/organization/attendance/worklogs/{uuid}/approve` — `routes/api/v1/worklogs.php:30`, `permission:worklog.approve|worklog.approve_any`
- `POST /api/v1/organization/attendance/worklogs/{uuid}/reject` — `routes/api/v1/worklogs.php:31`, `permission:worklog.approve|worklog.approve_any`

### C. Request body
Neither route uses the dedicated `ApproveWorklogRequest`/`RejectWorklogRequest` classes — validated inline via plain `Request`:
| Action | Field | Required | Rules (as actually enforced) |
|---|---|---|---|
| Approve | `remarks` | optional | `string`, `max:255` |
| Reject | `rejection_reason` | **required** | `string`, `max:255` |

(The dead `ApproveWorklogRequest`/`RejectWorklogRequest` classes specify `max:500` and `min:5|max:500` respectively — those are **not** the live rules.)

### D. Listing-specific
N/A.

### E. Response shape
`AttendanceWorklogResource` (workflow 13E), HTTP 200, messages `"Worklog approved successfully."` / `"Worklog rejected successfully."`.

### F. State/validation rules
- Allowed transitions: DRAFT→SUBMITTED; SUBMITTED→{SUBMITTED (multi-level first step), APPROVED, REJECTED, AUTO_APPROVED}; APPROVED→LOCKED; REJECTED→{DRAFT, SUBMITTED}; AUTO_APPROVED→LOCKED. Anything else → `INVALID_STATE_TRANSITION` (422).
- Multi-level approval: first `approve` call (no first approver recorded yet) only moves status back to `SUBMITTED` — a **second**, different approval call flips it to `APPROVED`.
- Every transition records a `statusHistories()` row.
- Note: a generic `PATCH worklogs/{uuid}/status` endpoint exists as a controller method but **has no route mapped to it** — only `approve`/`reject` are reachable.

---

## 15. VIEW / MANAGE WORKLOG POLICY

**Status: ✅ IMPLEMENTED**

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `worklog_policy.view` | Any holder | Org-wide singleton (read) |
| `worklog_policy.manage` | Any holder | Org-wide singleton (write) |

No hierarchy concept applies (org-wide config, not per-user data) — not a gap, by design.

### B. Endpoint(s)
`routes/api/v1/worklogs.php:16-20`, controller `WorklogPolicyController`:
- `GET /api/v1/organization/attendance/worklog-policy` (`show`) — `permission:worklog_policy.view`
- `PATCH /api/v1/organization/attendance/worklog-policy` (`update`) — `permission:worklog_policy.manage`
- `GET /api/v1/organization/attendance/worklog-policy/versions` (`versions`) — `permission:worklog_policy.view`

### C. Request body (update only)
`UpdateWorklogPolicyRequest::rules()` (`app/Http/Requests/Attendance/UpdateWorklogPolicyRequest.php:19-38`), all `sometimes`:
| Field | Type | Rules |
|---|---|---|
| `worklog_mode` | int enum | `Enum(WorklogMode)` — 1=STRICT,2=FLEXIBLE,3=HYBRID |
| `approval_flow` | int enum | `Enum(Worklog\ApprovalFlow)` — 1=AUTO,2=SINGLE_APPROVAL,3=MULTI_LEVEL_APPROVAL |
| `require_worklog_on_clockout`, `allow_deferred_submission`, `require_project_mapping`, `require_task_mapping`, `require_justification_on_overflow`, `auto_escalate_overdue_logs`, `require_description`, `allow_multiple_worklogs_per_session`, `billable_tracking_enabled` | bool | — |
| `submission_window_days`, `edit_grace_days`, `lock_after_days`, `min_description_length` | int | `min:0,max:255` |

No uuid fields (org-scoped singleton).

### D. Listing-specific (`versions`)
No filters/pagination — full `getPolicyVersions()` collection, hardcoded `version desc`.

### E. Response shape
`WorklogPolicyResource` (`app/Http/Resources/Attendance/WorklogPolicyResource.php:12-39`):
```json
{
  "organization_uuid": "string|null",
  "worklog_mode": { "value": "int", "label": "string" },
  "approval_flow": { "value": "int", "label": "string" },
  "require_worklog_on_clockout": "bool", "allow_deferred_submission": "bool",
  "submission_window_days": "int", "edit_grace_days": "int", "lock_after_days": "int",
  "require_description": "bool", "min_description_length": "int",
  "require_justification_on_overflow": "bool",
  "require_project_mapping": "bool", "require_task_mapping": "bool",
  "allow_multiple_worklogs_per_session": "bool", "auto_escalate_overdue_logs": "bool",
  "billable_tracking_enabled": "bool"
}
```
`WorklogPolicyVersionResource` — same fields plus `id` (**version number, not a uuid or row id — no per-version uuid is exposed at all**, the only resource in this document with that gap), `worklog_policy_uuid`, `created_by_uuid`, `created_at`, and richer sub-objects for `worklog_mode`/`approval_flow`.

### F. State/validation rules
- `show`/`update`/`versions` all first resolve/auto-create the org's `AttendancePolicy` — the worklog policy is dependent on an attendance policy existing.
- Worklog policy is auto-created with hardcoded defaults on first access.
- Every update creates a new immutable version row (row-locked `max(version)+1`, same pattern as Attendance Policy).

---

## 16. APPLY FOR LEAVE

**Status: ✅ IMPLEMENTED** — two working paths. `LeaveRequestController::store` (`leave-requests`) is documented as primary (feeds into the richer view/approve/cancel contract below); `LeaveController::store` (`organization/attendance/leaves`) is a fully-functional simpler alternative.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `leaves.create` (`SystemPermission::LEAVES_CREATE`) | Any holder | Self only — no target-user field exists anywhere on this request |

Both routes require `permission:leaves.create` at the route level (`routes/api/v1/leaves.php:19` for `LeaveRequestController::store`, `:59` for `LeaveController::store`). No hierarchy scoping applies (always self).

### B. Endpoint
**Primary:** `POST /api/v1/leave-requests` — `routes/api/v1/leaves.php:13-25` (`LeaveRequestController::store`), `permission:leaves.create`.

**Also works:** `POST /api/v1/organization/attendance/leaves` — `routes/api/v1/leaves.php:53-62` (`LeaveController::store`), `permission:leaves.create`.

### C. Request body
Both controllers use the **same** FormRequest, `App\Http\Requests\Leave\SubmitLeaveRequest` (`app/Http/Requests/Leave/SubmitLeaveRequest.php:17-27`) — identical contract on either path:
| Field | Type | Required | Rules |
|---|---|---|---|
| `leave_type_id` | uuid | required | `string\|uuid` |
| `start_date` | date | required | `date_format:Y-m-d`, `after_or_equal:today` |
| `end_date` | date | required | `date_format:Y-m-d`, `after_or_equal:start_date` |
| `reason` | string | required | `min:10,max:1000` |
| `is_half_day` | bool | optional | — |
| `attachment_path` | string | optional | `max:500` |

Note: a separate, older, unrelated FormRequest `App\Http\Requests\Attendance\LeaveRequest` also exists (non-uuid `leave_type` enum field) — dead code, not used by either controller. Ignore it.

### D. Listing-specific
N/A (create action).

### E. Response shape
Both return `LeaveRequestResource` (see the full shape in workflow 17E), HTTP 201. `user`/`approvedBy`/`rejectedBy` are not eager-loaded at submit time, so those fields will be absent; `leaveType`/`statusHistories` are present.

### F. State/validation rules
Both controllers route through the same `LeaveRequestService::submitLeave()`/`validateLeaveSubmission()`:
- Leave type must belong to the org and be active → `LeaveTypeNotActiveException` (422).
- Half-day requires a single-date request and both `policy.allow_half_day_leaves` and `leaveType.allow_half_day`.
- Advance notice: `start_date` must be ≥ today + `advance_notice_required_days` → `LeaveAdvanceNoticeException` (422).
- Max advance: `start_date` must be ≤ today + `max_advance_application_days` (422 on `start_date`).
- Per-request length must respect `leaveType.min_per_request_days`/`max_per_request_days` (422 on `end_date`).
- Document required if `leaveType.requires_document` or total days exceeds `policy.document_required_after_days` → `LeaveDocumentRequiredException` (422).
- Overlap with any existing non-rejected/non-cancelled leave → `LeaveOverlapException` (422).
- Attendance conflict: blocked (unless WFH/Extra-Working-Day type) if an approved adjustment or any attendance day with sessions exists in range → `LeaveAttendanceConflictException` (422).
- Balance: blocked if `leaveType.counts_towards_balance` and `!policy.negative_balance_allowed` and remaining balance would go negative → `InsufficientLeaveBalanceException` (422).
- On success, `pending_days` is incremented / `remaining_days` decremented on the user's `LeaveBalance` row. This is correctly reversed **if** the leave is later approved/rejected/cancelled via `LeaveRequestController` (workflow 19/20) — but **not** if the same leave is instead actioned via `LeaveController`'s status-update endpoint, which never touches balances (see workflow 19F). **Pick one path per leave lifecycle and stick to it** — mixing `LeaveController` for approval with balance-reads elsewhere will show wrong numbers.
- ⚠️ **Balance-write gap:** the `counts_towards_balance=false` exemption (used for Unpaid Leave types) only skips the *validation*, not the balance *write* — `remaining_days` on a balance-exempt type can silently go negative with no block.
- ⚠️ **Latent bug:** custom leave types with a non-numeric `code` will throw an uncaught `ValueError` (500) the first time anyone submits leave against them (`LeaveTypeEnum::from((int)$leaveType->code)` with no fallback) — a live risk since custom-type creation (workflow 22) is reachable for anyone holding `leave_policy.manage`.

---

## 17. VIEW LEAVE REQUESTS (self + as approver, all filters)

**Status: ✅ IMPLEMENTED** via `LeaveRequestController` — gives a real, hierarchy-scoped approver queue with filters and pagination. `LeaveController` remains available as a simpler, self-only, unpaginated alternative.

### A. Who can do this

**Primary path — `LeaveRequestController`:** no route-level permission gate; scoping done inline in `LeaveRequestService::getLeaveRequests()`/`getLeaveRequest()`:
| Permission required | Who holds scope | Can target |
|---|---|---|
| none | Any authenticated org member | Self only — `user_id` filter for anyone else → 403 `UNAUTHORIZED_LEAVE_ACTION` |
| `leaves.view` or `leaves.approve` | Holder | Self + subordinates (`reports_to` + dept-head's department) |
| `leaves.approve_any` or `platform.full_access` | Holder | Org-wide, no hierarchy check on the `user_id` filter |

**Mobile param note:** the controller only whitelists a query param named **`user_id`** (a uuid string) — `user_uuid` is silently stripped. Use `user_id`.

**Alternate path — `LeaveController`:**
| Endpoint | Permission required | Actual scope |
|---|---|---|
| `index` (`GET .../leaves`) | `leaves.view` | **Always self only, unconditionally** — hardcoded, no `user_id` param, no approver branch at all |
| `show` (`GET .../leaves/{uuid}`) | `leaves.view` | Self always OK; else requires `leaves.view` + hierarchy match via `EmployeeLeavePolicy::view()`; `leaves.approve_any` bypasses hierarchy |

### B. Endpoint(s)
**Primary:** `GET /api/v1/leave-requests` (`index`) and `GET /api/v1/leave-requests/{uuid}` (`show`) — `routes/api/v1/leaves.php:18,21`. No `permission:` middleware at route level (self-service, see workflow 16A).

**Also works (simpler, self-only):** `GET /api/v1/organization/attendance/leaves` and `/{uuid}` — `routes/api/v1/leaves.php:58,60`, `permission:leaves.view`.

### C. Request body
N/A (GET).

### D. Listing-specific
`LeaveRequestController::index` (`LeaveRequestController.php:26-44`) validates:
| Param | Type | Filters against |
|---|---|---|
| `start_date` | date `Y-m-d` | `start_date >= X` (not a range/overlap filter) |
| `end_date` | date `Y-m-d`, `after_or_equal:start_date` | `end_date <= X` |
| `leave_status` | int (raw `LeaveStatus` value 1-7) | `leave_status = X` exact |
| `leave_type_id` | uuid | resolved to internal id; silently ignored if it doesn't resolve |
| `user_id` | uuid | hierarchy-checked, see A |
| `per_page` | int, `min:1,max:100` | default **20** |

No `sort`/`order` param — hardcoded `orderBy('created_at', 'desc')`. Real Laravel pagination.

*(`LeaveController::index` by contrast accepts **zero** query params — no filters, no pagination, sorted `start_date` descending, always self.)*

### E. Response shape
**Envelope note:** `LeaveRequestController` does not extend `BaseApiController`, so `index` wraps the response differently from every other controller in this document: `{success:true, data: <Laravel's full paginated-resource envelope: {data:[...], links:{...}, meta:{...}}>}` — pagination metadata **is** present here (nested one level deeper). `show`/`store`/etc. return `{success, message, data}` only (no `errors`/`meta` keys at all).

`LeaveRequestResource::toArray()` (`app/Http/Resources/Leave/LeaveRequestResource.php:13-72`):
```json
{
  "uuid": "string", "organization_uuid": "string (when loaded)",
  "user": { "uuid": "string", "name": "string", "email": "string" },
  "leave_type": { "uuid": "string", "name": "string", "code": "string", "color_hex": "string", "is_paid": "bool" },
  "leave_status": { "value": "int", "label": "string" },
  "approval_flow": { "value": "int", "label": "enum case name, e.g. SINGLE_APPROVAL" },
  "start_date": "Y-m-d", "end_date": "Y-m-d", "total_days": "float",
  "is_carry_forward": "bool", "reason": "string", "attachment_path": "string|null",
  "approved_by": { "uuid": "string", "name": "string" },
  "approved_at": "ISO8601|null", "auto_approved_at": "ISO8601|null",
  "second_approver": { "uuid": "string", "name": "string" },
  "second_approved_at": "ISO8601|null",
  "rejected_by": { "uuid": "string", "name": "string" },
  "rejected_at": "ISO8601|null", "rejection_reason": "string|null (alias of the same column as cancellation_reason)",
  "second_rejected_by": "always null — never set anywhere in the codebase",
  "second_rejected_at": "always null — never set anywhere in the codebase",
  "cancellation_reason": "string|null",
  "has_first_level_approval": "bool",
  "status_histories": "LeaveStatusHistoryResource[] (when loaded)",
  "created_at": "ISO8601", "updated_at": "ISO8601"
}
```
`leave_status` values (`app/Enums/Leave/LeaveStatus.php`): 1=Draft, 2=Pending, 3=Approved, 4=Rejected, 5=Cancelled, 6=Expired, 7=Auto Approved.

*(`LeaveController`'s `index`/`show` return the much thinner `EmployeeLeaveResource` instead — no `uuid`/`name` for `leave_type`, no `user`, no `approved_by`/`rejected_by`, no `status_histories`. If you build against `LeaveController`, don't expect the fields above.)*

### F. State/validation rules
Read-only — see §A for scoping.

---

## 18. VIEW LEAVE BALANCES

**Status: ✅ IMPLEMENTED** — `LeaveController` has no equivalent; this is only available via `LeaveRequestController`.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| none (any authenticated org member) | — | **Self only, always.** No `user_id`/`user_uuid` param anywhere; a manager cannot view a subordinate's balance. |

### B. Endpoint
`GET /api/v1/leave-requests/balances` — `routes/api/v1/leaves.php:20`. No permission middleware (self-scoped by design).

### C. Request body
N/A (GET). Only query param: `year` (int, defaults to current year), unvalidated/unbounded.

### D. Listing-specific
No pagination (plain collection), no filters besides `year`, no sorting. One row per `(leave_type, year)` combination the user has actually touched — balances are not pre-seeded for every active leave type.

### E. Response shape
`LeaveBalanceResource` (`app/Http/Resources/Leave/LeaveBalanceResource.php:12-28`):
```json
{
  "leave_type": { "uuid": "string", "name": "string", "code": "string", "color_hex": "string" },
  "year": "int",
  "allocated_days": "float", "carry_forward_days": "float",
  "used_days": "float", "pending_days": "float", "remaining_days": "float"
}
```

### F. State/validation rules
Balance rows are created lazily on first submission (workflow 16F), then mutated by submit/approve/reject/cancel. ⚠️ **These numbers are only accurate if approve/reject/cancel is always done through `LeaveRequestController` (workflows 19/20).** If a leave is instead actioned through `LeaveController`'s status-update endpoint, its balance never gets finalized and this endpoint will show stale `pending_days`/`remaining_days` for it. **Mobile team implication:** build this screen against `LeaveRequestController`'s full lifecycle (submit → approve/reject/cancel all via that controller) to keep the numbers trustworthy; don't mix in `LeaveController` for the same leave records.

---

## 19. APPROVE / REJECT LEAVE

**Status: ✅ IMPLEMENTED** via `LeaveRequestController` — hierarchy, `approve_any` bypass, self-approval block, and balance finalization all work end-to-end. `LeaveController`'s status-update endpoint also works but has real correctness gaps — see below.

### A. Who can do this

**Primary path — `LeaveRequestController`:** route middleware requires `leaves.approve|leaves.approve_any` (`routes/api/v1/leaves.php:22-23`); hierarchy scoping is then decided in `LeaveRequestService::assertCanApprove()`:
| Permission required | Who holds scope | Can target |
|---|---|---|
| `leaves.approve` (route accepts this OR `approve_any`) | Holder who is the target's direct `reports_to` manager or their dept head | Direct reports / department members — never self |
| `leaves.approve_any` or `platform.full_access` | Bypasses hierarchy | Any user in the org — still never self |

An `approve_any`-only holder (no plain `leaves.approve`) passes the route gate correctly, since the middleware accepts either.

**Alternate path — `LeaveController::updateStatus`:** same permission model, same `leaves.approve|leaves.approve_any` route gate (`routes/api/v1/leaves.php:61`).

### B. Endpoint
**Primary:** `POST /api/v1/leave-requests/{uuid}/approve` and `POST /api/v1/leave-requests/{uuid}/reject` — `routes/api/v1/leaves.php:22-23`, `permission:leaves.approve|leaves.approve_any`. Dedicated separate endpoints (not a shared status field).

**Also works, simpler but with gaps (see F):** `PATCH /api/v1/organization/attendance/leaves/{uuid}/status` with `status=3`/`status=4` — `routes/api/v1/leaves.php:53-62` (`LeaveController::updateStatus`), `permission:leaves.approve|leaves.approve_any`.

### C. Request body
- Approve — `ApproveLeaveRequest::rules()`: `remarks` — optional, string, `max:500`. `authorize()` returns `true` unconditionally by design (delegates to the service).
- Reject — `RejectLeaveRequest::rules()`: `rejection_reason` — **required**, string, `min:5,max:500`. Same `authorize(): true` pattern.

*(`LeaveController`'s alternate path uses `UpdateLeaveStatusRequest` instead: `status` int enum required, `remarks` optional max:255, `metadata` optional array.)*

### D. Listing-specific
N/A.

### E. Response shape
`LeaveRequestResource` (workflow 17E — the rich shape), with `user`, `leaveType`, `approvedBy`, `rejectedBy`, `statusHistories` all eager-loaded.

*(`LeaveController`'s alternate path returns the thin `EmployeeLeaveResource` instead — workflow 17E.)*

### F. State/validation rules
`LeaveRequestService::approveLeave()`/`rejectLeave()` (the primary path):
- Must currently be `PENDING`, else `LeaveRequestAlreadyProcessedException` (422).
- `SINGLE_APPROVAL` flow: approve sets `approved_by`/`approved_at`, status → `APPROVED`, `used_days += total_days; pending_days -= total_days`.
- `MULTI_LEVEL_APPROVAL` flow: first approval only records `approved_by`/`approved_at` (no balance change yet); the second approval call flips to `APPROVED` and applies the balance change. **Gap:** nothing prevents the same approver from being recorded as both first and second approver.
- Reject: sets `rejected_by`/`rejected_at`/`cancellation_reason` (same DB column reused by cancel), status → `REJECTED`, `pending_days -= total_days; remaining_days += total_days`.
- `second_rejected_by`/`second_rejected_at` exist on the model/resource but are **never set anywhere in the codebase** — always null.

**`LeaveController`'s alternate path** (`LeaveStatusTransitionService::transition()`) is a different, simpler state machine — remains a valid choice for simple single-approval orgs, but has two real gaps if you use it instead:
- 🔴 **No multi-level approval support** — always single-step, even if the policy's `approval_flow = MULTI_LEVEL_APPROVAL`.
- 🔴 **No balance mutation at all** — `used_days`/`pending_days`/`remaining_days` are left exactly as set at submission, regardless of approve/reject outcome. If you use this endpoint, balances (workflow 18) will be wrong for those leaves.

---

## 20. CANCEL LEAVE

**Status: ✅ IMPLEMENTED** via `LeaveRequestController::cancel` — a dedicated, owner-only, self-service endpoint that actually works. `LeaveController`'s alternate cancellation path (same status endpoint as approve/reject, `status=5`) remains gated behind `leaves.approve`/`leaves.approve_any` and is not usable for self-service by regular employees.

### A. Who can do this

**Primary path — `LeaveRequestController::cancel`:**
| Permission required | Who holds scope | Can target |
|---|---|---|
| none — ownership check only | — | **Only the leave's own owner.** `CancelLeaveRequest::authorize()` returns `true` unconditionally; the real gate is `leave.user_id !== canceller.id` → `UnauthorizedLeaveActionException` (403) inside `LeaveRequestService::cancelLeave()`. |

No hierarchy concept applies, no `user_uuid` param — genuinely self-service, no permission needed beyond being an org member and owning the leave.

**Alternate path — `LeaveController`'s status endpoint (`status=5`):** requires `leaves.approve` or `leaves.approve_any` at the route level, so **an ordinary employee without an approval-tier permission cannot use this path to cancel even their own leave** — the service layer has a self-cancel carve-out, but it's unreachable because the route middleware blocks non-approvers first. Only useful for managers cancelling their own or a subordinate's leave.

### B. Endpoint
**Primary (self-service):** `POST /api/v1/leave-requests/{uuid}/cancel` — `routes/api/v1/leaves.php:24`.

**Alternate (approvers only):** `PATCH /api/v1/organization/attendance/leaves/{uuid}/status` with `status: 5` — see workflow 19B.

### C. Request body
`CancelLeaveRequest::rules()`: `reason` — required, string, `min:5,max:500`.

*(Alternate path: `UpdateLeaveStatusRequest` — `status: 5`, optional `remarks`.)*

### D. Listing-specific
N/A.

### E. Response shape
`LeaveRequestResource` (workflow 17E, the rich shape).

### F. State/validation rules
- Owner-only (see A).
- Requires the org's leave policy to have `allow_leave_cancellation` truthy, else `LeaveCancellationNotAllowedException` (422).
- Only `PENDING`, `APPROVED`, `AUTO_APPROVED` are cancellable — anything else → `LeaveRequestAlreadyProcessedException` (422).
- For already-approved leaves: must cancel at least `policy.cancellation_before_hours` (default 24) before `start_date`, else `LeaveCancellationNotAllowedException` (422). **Pending leaves have no time-based restriction.**
- Balance reversal: cancelling `PENDING` reverses `pending_days`/`remaining_days`; cancelling `APPROVED`/`AUTO_APPROVED` reverses `used_days`/`remaining_days`.

*(`LeaveController`'s alternate path has none of the above policy/time checks, and does not reverse balances at all — see workflow 19F.)*

---

## 21. VIEW / MANAGE LEAVE POLICY

**Status: ✅ IMPLEMENTED** — view and manage are both permission-gated at the route level.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `leave_policy.view` (`index`/`show`/`versions`) | Holder | Org-wide singleton policy (read) |
| `leave_policy.manage` (`store`/`update`) | Holder | Org-wide singleton policy (create/update) |

Gate lives in route middleware (`routes/api/v1/leaves.php:32-36`); FormRequest `authorize()` methods just `return true`. No hierarchy/`user_uuid` concept applies — one policy per org (`LeavePolicyAlreadyExistsException` enforces uniqueness).

### B. Endpoint(s)
`routes/api/v1/leaves.php:28-37`, `Route::prefix('leave/policy')->middleware(['api.organization'])`:
- `GET /api/v1/leave/policy` (`index` — despite the name, returns the org's single policy, not a list) — `permission:leave_policy.view`
- `POST /api/v1/leave/policy` (`store`) — `permission:leave_policy.manage`
- `GET /api/v1/leave/policy/{uuid}` (`show`) — `permission:leave_policy.view`
- `PUT /api/v1/leave/policy/{uuid}` (`update`) — `permission:leave_policy.manage`
- `GET /api/v1/leave/policy/{uuid}/versions` (`versions`) — `permission:leave_policy.view`

### C. Request body
`CreateLeavePolicyRequest::rules()` (`app/Http/Requests/Leave/CreateLeavePolicyRequest.php:21-38`):
| Field | Type | Required | Rules |
|---|---|---|---|
| `approval_flow` | int enum | required | `Enum(ApprovalFlowEnum)` — 1=AUTO,2=SINGLE_APPROVAL,3=MULTI_LEVEL_APPROVAL |
| `allow_half_day_leaves` | bool | required | — |
| `allow_leave_on_weekends` | bool | required | — |
| `allow_leave_on_holidays` | bool | required | — |
| `advance_notice_required_days` | int | required | `min:0,max:30` |
| `max_advance_application_days` | int | required | `min:1,max:365` |
| `document_required_after_days` | int | required | `min:1,max:30` |
| `allow_leave_cancellation` | bool | required | — |
| `cancellation_before_hours` | int | required | `min:0,max:720` |
| `carry_forward_enabled` | bool | required | — |
| `max_carry_forward_days` | int | `required_if:carry_forward_enabled,true` | `min:0,max:365` |
| `carry_forward_expiry_months` | int | `required_if:carry_forward_enabled,true` | `min:1,max:12` |
| `accrual_enabled` | bool | required | — |
| `accrual_frequency` | int enum | `required_if:accrual_enabled,true` | `Enum(AccrualFrequencyEnum)` — 1=MONTHLY,2=QUARTERLY |
| `negative_balance_allowed` | bool | required | — |
| `auto_approve_after_hours` | int | optional | `min:1,max:720` |

`UpdateLeavePolicyRequest::rules()` — identical fields, `sometimes|required|...` for partial update. Both `authorize()` methods just `return true` — the gate is in route middleware.

### D. Listing-specific
`index`/`show` return a single resource, no pagination. `versions` returns a plain (non-paginated) `Collection`, hardcoded `orderBy('version', 'desc')`, no filters.

### E. Response shape
Envelope: standard `{success, message, data, errors, meta}` (this controller extends `BaseApiController`, unlike `LeaveRequestController`/`LeaveController`).

`LeavePolicyResource` (`app/Http/Resources/Leave/LeavePolicyResource.php:14-46`):
```json
{
  "uuid": "string", "organization_uuid": "string",
  "approval_flow": { "value": "int", "label": "string", "description": "string", "requires_approver": "bool", "requires_second_approver": "bool" },
  "allow_half_day_leaves": "bool", "allow_leave_on_weekends": "bool", "allow_leave_on_holidays": "bool",
  "advance_notice_required_days": "int", "max_advance_application_days": "int", "document_required_after_days": "int",
  "allow_leave_cancellation": "bool", "cancellation_before_hours": "int",
  "carry_forward_enabled": "bool", "max_carry_forward_days": "int|null", "carry_forward_expiry_months": "int|null",
  "accrual_enabled": "bool", "accrual_frequency": { "value": "int", "label": "string" } | null,
  "negative_balance_allowed": "bool", "auto_approve_after_hours": "int|null",
  "current_version": "int",
  "leave_types": "LeaveTypeResource[] (when loaded)",
  "created_at": "datetime", "updated_at": "datetime"
}
```
`LeavePolicyVersionResource` — same fields minus `organization_uuid`/`current_version`/`leave_types`, plus `id` (**version number, not a row id**), `leave_policy_uuid`, `created_by_uuid`, `created_at`.

### F. State/validation rules
- `createPolicy` blocks duplicates per org (409); creates policy + version-1 snapshot atomically.
- `updatePolicy` computes `nextVersion` under a row lock, applies the diff, writes an immutable new version snapshot — old versions are never mutated.
- **This controller's `getPolicy()`/`getPolicyByUuid()` do NOT auto-provision a default policy** (unlike the leave-submission path, which does via `LeaveRequestService::submitLeave` → `LeavePolicyService::getOrCreatePolicy`) — a fresh org gets `404 LEAVE_POLICY_NOT_FOUND` from `GET /api/v1/leave/policy` until either `store` succeeds or someone submits a leave through `LeaveController`/`LeaveRequestController` (workflow 16), which auto-provisions a default policy + 4 default types as a side effect.

---

## 22. VIEW / MANAGE LEAVE TYPES

**Status: ✅ IMPLEMENTED** — every action is permission-gated at the route level.

### A. Who can do this
| Permission required | Who holds scope | Can target |
|---|---|---|
| `leave_policy.view` (`index`/`show`) | Holder | Any leave type in the org (read) |
| `leave_policy.manage` (`store`/`update`/`deactivate`/`destroy`) | Holder | Any leave type in the org (write) |

There is no dedicated `SystemPermission` case for leave types specifically — every action reuses `LEAVE_POLICY_*` (the same permissions gating policy view/manage, workflow 21), since types are administered as part of leave-policy management.

### B. Endpoint(s)
`routes/api/v1/leaves.php:41-50`, `Route::middleware(['api.organization'])`:
- `GET /api/v1/leave/policy/{policyUuid}/types` (`index`) — `permission:leave_policy.view`
- `POST /api/v1/leave/policy/{policyUuid}/types` (`store`) — `permission:leave_policy.manage`
- `GET /api/v1/leave/types/{uuid}` (`show`) — `permission:leave_policy.view`
- `PUT /api/v1/leave/types/{uuid}` (`update`) — `permission:leave_policy.manage`
- `PATCH /api/v1/leave/types/{uuid}/deactivate` (`deactivate`) — `permission:leave_policy.manage`
- `DELETE /api/v1/leave/types/{uuid}` (`destroy`) — `permission:leave_policy.manage`

### C. Request body
`CreateLeaveTypeRequest::rules()` (`app/Http/Requests/Leave/CreateLeaveTypeRequest.php:18-31`):
| Field | Type | Required | Rules |
|---|---|---|---|
| `name` | string | required | `max:100` |
| `code` | string | required | `max:50`, `alpha_dash` — **not numeric-constrained**, see F for the resulting crash risk |
| `color_hex` | string | optional | `regex:/^#[0-9A-Fa-f]{6}$/` |
| `is_paid` | bool | required | — |
| `requires_document` | bool | required | — |
| `allow_half_day` | bool | required | — |
| `annual_allocation_days` | numeric | required | `min:0.5,max:365` |
| `max_per_request_days` | int | optional | `min:1,max:365` |
| `min_per_request_days` | numeric | required | `min:0.5,max:30` |
| `is_active` | bool | required | — |
| `sort_order` | int | optional | `min:0,max:255` |

**Gap:** `counts_towards_balance` is **not in this request's rules at all** — a mobile client creating a custom leave type has no way to mark it balance-exempt; it always defaults to `true` at the DB level. `UpdateLeaveTypeRequest::rules()` mirrors these fields, same absence.

### D. Listing-specific
`index` accepts **zero query params** — no filters, no pagination, no sorting. Always `ORDER BY sort_order ASC, id ASC`, and **always excludes inactive types** — no way to retrieve deactivated types through this endpoint even though `deactivate` exists as an action.

### E. Response shape
Standard `{success, message, data, errors, meta}` envelope. `LeaveTypeResource` (`app/Http/Resources/Leave/LeaveTypeResource.php:14-32`):
```json
{
  "uuid": "string", "organization_uuid": "string", "leave_policy_uuid": "string",
  "name": "string", "code": "string", "color_hex": "string|null",
  "is_paid": "bool", "is_system_type": "bool", "requires_document": "bool", "allow_half_day": "bool",
  "annual_allocation_days": "numeric", "max_per_request_days": "numeric|null", "min_per_request_days": "numeric",
  "is_active": "bool", "sort_order": "int|null",
  "created_at": "datetime", "updated_at": "datetime"
}
```
**Gap:** `counts_towards_balance` exists on the model but is **not exposed in this resource at all**.

### F. State/validation rules
- `createType` uppercases `code`, blocks duplicate codes per org (409).
- `updateType` — same duplicate-code check, excluding self.
- `deactivateType` — flips `is_active=false` only; **no check for existing pending leave requests against the type** before deactivating.
- `deleteType` — system types (the 4 auto-seeded defaults) cannot be deleted (422); others are soft-deleted.
- ⚠️ **Cross-cutting risk** (also in workflow 16F): nothing here validates `code` against the numeric range 1–11 required by the `Leave\LeaveType` enum used at submission time — a custom type with a non-numeric/out-of-range `code` passes creation successfully but causes an uncaught `ValueError` (500) the first time anyone submits leave against it. A live risk for any user holding `leave_policy.manage`.

---

## Mobile App Quick-Reference Table

| # | Workflow | Method + Path | Permission | Pagination | `user_uuid` filter | Status |
|---|---|---|---|---|---|---|
| 1 | Clock In | `POST /api/v1/organization/attendance/clock-in` | `attendance.create` | N/A | N/A (self only) | ✅ IMPLEMENTED |
| 2 | Clock Out | `POST /api/v1/organization/attendance/clock-out` | `attendance.create` | N/A | N/A (self only) | ✅ IMPLEMENTED |
| 3 | View Today | `GET /api/v1/organization/attendance/today` | `attendance.view` | N/A (single record) | Yes, hierarchy-checked | ⚠️ PARTIAL (`approved_by_uuid` always null) |
| 4 | View History | `GET /api/v1/organization/attendance/history` | `attendance.view` | Yes, but `meta` dropped (default 30, 5-100) | Yes, hierarchy-checked | ⚠️ PARTIAL (same gap + no page-count visibility) |
| 5 | View/Manage Attendance Policy | `GET/PUT /api/v1/organization/attendance/policy`, `GET .../policy/versions` | `attendance_policy.view` / `.manage` | No (singleton + unpaginated versions) | N/A | ✅ IMPLEMENTED (legacy `v1/attendance/policy/*` also reachable — same underlying data, use org-scoped path for simpler contract) |
| 6 | Submit Adjustment | `POST /api/v1/organization/attendance/adjustments` | `attendance_adjustments.create` | N/A | N/A | ⚠️ PARTIAL (no day-ownership check) |
| 7 | View Adjustments | `GET /api/v1/organization/attendance/adjustments` | `attendance_adjustments.view` | Yes, `meta` dropped (default 30, 5-100) | Yes, hierarchy-checked | ⚠️ PARTIAL (pagination meta gap) |
| 8 | Approve/Reject Adjustment | `PUT .../adjustments/{uuid}/approve`, `/reject` | `attendance.approve`\|`.approve_any` | N/A | N/A | ✅ IMPLEMENTED |
| 9 | View Escalations | `GET /api/v1/organization/attendance/escalations`, `/{uuid}` | `attendance_escalations.view` | List yes (meta dropped); show N/A | List hierarchy-checked; **show is not** | ⚠️ PARTIAL (show bypasses hierarchy) |
| 10 | Resolve/Dismiss Escalation | `PATCH .../escalations/{uuid}/status` | `attendance_escalations.resolve` | N/A | N/A (no hierarchy check — gap) | ⚠️ PARTIAL (+ bad `status` value → 500) |
| 11 | Submit Worklog | `POST .../days/{dayUuid}/worklogs` | `worklog.create` | N/A | N/A (self only) | ✅ IMPLEMENTED |
| 12 | Edit/Delete Worklog | `PUT`/`DELETE .../worklogs/{uuid}` | `worklog.create` | N/A | N/A (owner only) | ⚠️ PARTIAL (**PUT 500s** — `ArgumentCountError`; DELETE OK) |
| 13 | View Worklogs | `GET .../days/{dayUuid}/worklogs`, `GET .../worklogs`, `GET .../worklogs/{uuid}` | `worklog.view` | index yes (meta dropped); forDay no | index **not** hierarchy-checked (gap); show is | ⚠️ PARTIAL (index org-wide leak) |
| 14 | Approve/Reject Worklog | `POST .../worklogs/{uuid}/approve`, `/reject` | `worklog.approve`\|`.approve_any` | N/A | N/A | ✅ IMPLEMENTED |
| 15 | View/Manage Worklog Policy | `GET/PATCH .../worklog-policy`, `GET .../worklog-policy/versions` | `worklog_policy.view` / `.manage` | No | N/A | ✅ IMPLEMENTED |
| 16 | Apply For Leave | `POST /api/v1/leave-requests` (primary); `organization/attendance/leaves` also works | `leaves.create` | N/A | N/A (self only) | ✅ IMPLEMENTED |
| 17 | View Leave Requests | `GET /api/v1/leave-requests`, `/{uuid}` (primary — real approver queue); `organization/attendance/leaves` also works (self-only, thin) | none at route (self-service, scoping is internal); `leaves.view` on the alternate path | Yes on primary path (nested envelope, default 20, 1-100) | Yes, param is `user_id`, hierarchy-checked | ✅ IMPLEMENTED |
| 18 | View Leave Balances | `GET /api/v1/leave-requests/balances` | none (self only, always) | No | N/A | ✅ IMPLEMENTED |
| 19 | Approve/Reject Leave | `POST /api/v1/leave-requests/{uuid}/approve`, `/reject` (primary — proper balance handling); status-endpoint alternate has gaps | `leaves.approve`\|`.approve_any` | N/A | N/A | ✅ IMPLEMENTED |
| 20 | Cancel Leave | `POST /api/v1/leave-requests/{uuid}/cancel` (primary — real self-service) | none (owner-only check) | N/A | N/A | ✅ IMPLEMENTED |
| 21 | View/Manage Leave Policy | `GET/POST/PUT /api/v1/leave/policy[/{uuid}]`, `GET .../versions` | `leave_policy.view` (read) / `.manage` (write) | No | N/A | ✅ IMPLEMENTED |
| 22 | View/Manage Leave Types | `GET/POST/PUT/PATCH/DELETE /api/v1/leave/policy/{policyUuid}/types`, `/api/v1/leave/types/{uuid}[/deactivate]` | `leave_policy.view` (read) / `.manage` (write) | No | N/A | ✅ IMPLEMENTED |

**Build order recommendation for the mobile team:** workflows 1, 2, 3, 4, 5, 8, 11, 14, 15, 16, 17, 18, 19, 20, 21, 22 are solid — build these first, using `LeaveRequestController` (`/leave-requests/*`) as the primary path for the whole leave lifecycle (submit → view → approve/reject/cancel) since it's the one with correct balance handling and multi-level approval support. Workflows 6/7/9/10/12/13 work but each carries a documented gap — safe to build the UI, just don't rely on the specific behaviors flagged. One consistency note: `LeaveController` (`organization/attendance/leaves/*`) remains fully functional as a simpler alternative for submit/view, but its approve/reject/cancel action never finalizes the leave balance — if any part of the mobile app uses `LeaveController` to action a leave, workflow 18's balance numbers for that leave will be wrong. Pick one path per leave record's full lifecycle.
