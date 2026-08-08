# Cross-Module Consistency Notes: Attendance, Worklog, & Leave Modules

**Generated:** 2026-08-08  
**Target Modules:** Attendance, Worklog, Leave

---

## 1. Filter Parameter Conventions

| Feature / Filter | Attendance Module | Worklog Module | Leave Module | Alignment Recommendation |
| :--- | :--- | :--- | :--- | :--- |
| **Employee Filter Name** | `user_uuid` | `user_uuid` | `user_id` (accepts UUID) | ⚠️ **Align Leave Module:** Change `user_id` parameter key in `LeaveRequestController` to `user_uuid`. |
| **Date Range Filters** | `from` / `to` (or `start_date` / `end_date`) | `from` / `to` (or `start_date` / `end_date`) | `start_date` / `end_date` | ✅ Compatible across all modules. |
| **Date Column Target** | `attendance_date` | Linked `attendanceDay.attendance_date` | `start_date` / `created_at` | ✅ Explicitly documented per endpoint. |

---

## 2. Status Enum Consistency

* **Backed Enum Type:** All three modules consistently use **Integer-backed enums** (`int` values: `1, 2, 3...`).
* **Resource Presentation:** Every resource across all three modules exposes both the raw integer value (e.g. `attendance_status: 1`) and the human-readable string label (e.g. `attendance_status_label: "Present"`).

---

## 3. Pagination Standard

* **Attendance Module:** Default `30`, min `5`, max `100`.
* **Worklog Module:** Default `30`, min `5`, max `100`.
* **Leave Module:** Default `20`, min `1`, max `100` (`LeaveRequestController.php:35`).
* **Recommendation:** Standardize Leave module default pagination to `30` to match Attendance and Worklog listing standards.

---

## 4. Permission & Scoping Consistency

1. **Hierarchy Scoping Trait (`ResolvesApprovalHierarchy`):**
   * Attendance & Worklog modules consume `ResolvesApprovalHierarchy` for manager-level user resolution (`reports_to` → department head fallback).
   * Leave module (`LeaveRequestController`) does **not** currently consume `ResolvesApprovalHierarchy`, leading to incomplete manager dashboard scoping.
2. **Permission Enum Alignment:**
   * Attendance and Worklog endpoints strictly reference `SystemPermission` enum constants in route definitions.
   * Leave Module's `LeaveRequestController::index` line 290 references `'leave.request.view_all'` as a raw string which is missing from `SystemPermission.php`.
   * **Recommendation:** Replace `'leave.request.view_all'` with `SystemPermission::LEAVES_VIEW` and integrate `ResolvesApprovalHierarchy` in `LeaveRequestService`.
