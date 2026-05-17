# TimeNest Complete Architectural & Flow Audit

This document is an exhaustive, implementation-level audit of the current TimeNest backend. It serves as internal engineering documentation, a security audit, and an architecture review.

---

## 1. PROJECT OVERVIEW

### System Functionality
TimeNest is an enterprise-grade Software-as-a-Service (SaaS) application built to manage human resources, payroll, attendance, and general operations. 

### Architecture Style & Patterns
- **Monolithic API:** Built on Laravel, serving a JSON API (v1).
- **Service Repository Pattern (Partial):** Controllers remain extremely thin. Validation happens in `FormRequests`. Business logic is strictly delegated to `Services/` (e.g., `AuthService`, `BranchService`). 
- **Action Pattern:** Specific, re-usable logic is extracted into single-responsibility Action classes (e.g., `IssueJwtAction`).
- **Multi-Tenant Architecture:** The system employs a "logical" multi-tenancy model (shared database, isolated by `corporation_id` foreign keys) rather than separate databases. Tenant scoping is strictly enforced at the middleware layer via JWT claims and `ResolveTenantContext`.

### Core Architectures
- **Authentication:** Custom JWT implementation utilizing `php-open-source-saver/jwt-auth`. Standard Sanctum is **not** used. Tokens contain custom claims (`guard`, `corporation_uuid`, `role`, `token_version`).
- **Authorization:** Powered by Spatie Laravel Permission but highly customized. Permissions are enumerated statically in `SystemPermission`. Roles are enumerated in `SystemRole`. Team-based permissions are leveraged to isolate roles per corporation.

---

## 2. COMPLETE REQUEST FLOW

### API: POST /api/v1/auth/login

#### Flow
1. **Route Hit:** `routes/api.php` L19 routes to `AuthController@login`.
2. **Middleware Execution:** `throttle:auth` runs to prevent brute-forcing.
3. **Request Validation:** `LoginRequest` validates `email` (string, required) and `password` (string, required).
4. **Controller Called:** `AuthController@login` invokes `AuthService@login(email, password, ip, userAgent)`.
5. **DB Queries:** `User::where('email', $email)->first()` executes.
6. **Conditions Checked:** 
   - Checks if user exists & password matches (`Hash::check`). **Failure:** Throws `AuthenticationException` ("Invalid credentials") -> Returns 401.
   - Checks `$user->is_active`. **Failure:** Throws `AuthenticationException` -> Returns 401.
   - Checks `$user->email_verified_at`. **Failure:** Returns array with `status => email_not_verified` -> Controller returns `403`.
   - Checks `$user->two_factor_enabled`. **Success (2FA):** Calls `IssueJwtAction@issueTempToken('2fa')`. Returns `200 OK` with temp token.
7. **Workspace Resolution:** If basic checks pass, calls `resolveWorkspaceAndIssueTokens()`.
   - **DB Queries:** Fetches `PlatformMembership` and `CorpMembership` for the user.
   - **Condition 1 (Platform):** If Platform Admin -> Issues Platform-Guard JWT + Refresh Token.
   - **Condition 2 (Single Corp):** If exactly 1 Corp Membership -> Issues Corp-Guard JWT + Refresh Token.
   - **Condition 3 (Multi Corp):** If 2+ Memberships -> Issues 5-minute Temp JWT (`workspace_selection`). Returns `200 OK` (requires workspace selection).
   - **Condition 4 (No Workspace):** Returns `200 OK` with `no_workspace` status.
8. **Logging:** `ActivityLog::create(...)` logs the login event.
9. **Response:** Controller wraps the array in `AuthTokenResource` and returns via `ApiResponse::success()`.

### API: GET /api/v1/corp/branches

#### Flow
1. **Route Hit:** `routes/api.php` L57 routes to `BranchController@index`.
2. **Middleware Execution:** 
   - `tm.jwt.auth`: Authenticates JWT signature and expiration.
   - `jwt.full`: Ensures the token is NOT a temp token.
   - `corp.access`: Ensures the JWT guard claim is `corp`.
   - `tenant.resolve`: Resolves `corporation_id` from JWT, checks if Corp is active, checks if Membership is active, and binds `tenant.corporation` to the service container. Sets `setPermissionsTeamId()`.
   - `throttle:corp`: Rate limits based on corp.
   - `permission:branches.view`: Checks if the user's role in the current tenant has the `branches.view` permission.
3. **Controller Called:** `BranchController@index` is executed.
4. **Service Called:** `BranchService@list(...)` fetches branches scoped to the `corporation_id` bound in the container.
5. **Response returned:** Formatted via `BranchResource::collection`.

---

## 3. ROLE & PERMISSION SYSTEM (VERY IMPORTANT)

The system uses `spatie/laravel-permission` but overrides standard behavior to support tenant scoping.

### Enums
All permissions and roles are hardcoded as PHP Enums to prevent DB drift and typos.
- **Roles:** `SystemRole` (AppOwner, AppSuperAdmin, CorpOwner, CorpSuperAdmin, HrManager, Employee, etc.)
- **Permissions:** `SystemPermission` (e.g., `branches.view`, `users.manage`). Grouped by modules (`module.action`).

### Tenant Isolation (Spatie Teams)
- The Spatie package's "Teams" feature is re-purposed for Corporations.
- When `ResolveTenantContext` middleware runs, it calls `setPermissionsTeamId($corporation->id)`.
- This ensures that when Laravel's `$user->can('branches.view')` is evaluated, it ONLY checks if the user has that permission *for the specific corporation they are currently logged into*. 
- Platform admins have a `NULL` team ID.

### Hierarchy & Assignment
| Role | Layer | Description |
| ---- | ----------- | ------------ |
| AppOwner | Platform | Hardcoded root access. Can manage all corporations. |
| CorpOwner | Corporation | Full access within a specific tenant. |
| HrManager | Corporation | Manage employees, attendance, payroll, but cannot delete the corporation. |
| Employee | Corporation | Minimal view access (own profile, own attendance). |

| API | Required Permission | Enforcement Layer |
| --- | ------------------- | ----------------- |
| POST /branches | `branches.create` | Route Middleware (`permission:branches.create`) |
| PUT /branches/{id} | `branches.edit` | Route Middleware (`permission:branches.edit`) |
| GET /platform/corp | `corporations.manage` | Route Middleware (`permission:corporations.manage`) |

---

## 4. FUNCTION CALL FLOW MAPPING

### Feature: Workspace Switching
`AuthController@switchCorporation`
→ Validates `SelectCorporationRequest` (uuid exists in corporations table).
→ Calls `AuthService@selectCorporation(user, uuid, switchMode=true)`
  → Validates `Corporation` is active.
  → Validates `CorpMembership` exists and is active for User + Corp.
  → Calls `ResolveCorpRole` (custom private method) to ensure user has a valid Role in this Corp.
  → Invalidates current JWT (`JWTAuth::invalidate`).
  → Calls `IssueJwtAction@issueAccessToken(Guard::Corp)`
  → Calls `IssueJwtAction@issueRefreshToken()`
  → Creates `ActivityLog` entry.
→ Controller returns `AuthTokenResource`.

---

## 5. DATABASE ARCHITECTURE

The application uses MySQL/PostgreSQL. Migrations map to this logical structure:

1. **Geographical Data:** `countries`, `states` (Static reference tables).
2. **Identity & Auth:**
   - `users`: Global identities.
   - `social_accounts`: Google OAuth links.
   - `refresh_tokens`: Stores SHA-256 hashes of active refresh tokens.
3. **Multi-Tenancy:**
   - `corporations`: The tenant entity.
   - `branches`, `departments`: Scoped by `corporation_id`.
4. **Memberships (Pivot/Link tables):**
   - `platform_memberships`: Links `users` to platform-level admin access.
   - `corporation_memberships`: Links `users` to `corporations`.
   - `employee_profiles`: A 1-to-1 extension of membership storing HR data (designation, salary, DOJ).
5. **RBAC (Spatie Tables):**
   - `roles`, `permissions`, `model_has_roles`, `role_has_permissions`.
   - **Crucial detail:** `model_has_roles` utilizes the `corporation_id` as the team foreign key.
6. **Logging:**
   - `audit_logs`: Entity state changes (created, updated, deleted).
   - `activity_logs`: User actions (login, logout, switched workspace).

---

## 6. AUTHENTICATION FLOW

The backend does NOT use Sanctum. It uses a strictly customized JWT implementation.

### Token Issuance Lifecycle
1. User logs in. 
2. `IssueJwtAction@issueAccessToken` generates a JWT. Custom claims are injected:
   - `user_uuid`: Identifies the user.
   - `guard`: `api`, `platform`, `corp`, or `temp`.
   - `corporation_id`: Injected if the guard is `corp`.
   - `token_version`: Fetched from the `users` table.
3. `IssueJwtAction@issueRefreshToken` generates an 80-char string. It hashes it (SHA-256) and stores the hash in `refresh_tokens`. The raw string is returned to the client.

### Token Invalidation & Versioning
- **Logout:** `JWTAuth::invalidate()` adds the JWT's `jti` to the blacklist cache.
- **Global Logout (Logout All Devices):** Increments `token_version` on the `User` model.
- **Validation:** When a request comes in, the custom middleware checks if the `token_version` in the JWT payload matches the DB `token_version`. If mismatched, it throws a `JwtTokenVersionMismatchException`. This instantly revokes all active JWTs globally upon password changes.

---

## 7. MIDDLEWARE EXECUTION FLOW

### 1. `JwtAuthenticate` (`tm.jwt.auth`)
- **Purpose:** Parses the Bearer token, validates signature and expiration.
- **Security Check:** Verifies `token_version` claim matches the DB.
- **Failure:** Returns 401 Unauthenticated.

### 2. `EnsureFullJwtAccess` (`jwt.full`)
- **Purpose:** Prevents Temp Tokens from accessing real APIs.
- **Security Check:** Ensures the `guard` claim is NOT `temp`.
- **Failure:** Returns 403 Forbidden.

### 3. `ResolveTenantContext` (`tenant.resolve`)
- **Purpose:** Hydrates the system with tenant context.
- **Security Check:** Reads `corporation_id` from JWT. Verifies Corp is active. Verifies `CorpMembership` is active.
- **Action:** Binds `tenant.corporation` to container. Sets Spatie Team ID.
- **Failure:** Returns 403 Forbidden ("Corporation membership is not active").

---

## 8. VALIDATION ARCHITECTURE

- **FormRequests:** All incoming data is validated strictly using Laravel FormRequests.
- **Security Validations:** e.g., `AddMemberRequest` not only checks data types but ensures role IDs being passed exist and are valid for the context.
- **Tenant Scoping in Validation:** Because validation happens *after* `ResolveTenantContext`, unique rules in FormRequests (e.g., "Branch name must be unique") can utilize `Rule::unique('branches')->where('corporation_id', app('tenant.corporation')->id)`.

---

## 9. SECURITY AUDIT & CODE REVIEW

### Strengths & Excellent Patterns
- **Token Versioning:** Incrementing a DB integer to invalidate all active stateless JWTs instantly is an enterprise-grade security pattern.
- **Decoupled Roles from DB Lookups:** Embedding `corporation_id` and `role` directly into JWT claims drastically reduces database queries on every request.
- **SHA-256 Refresh Tokens:** Storing hashes rather than raw refresh tokens ensures database dumps do not compromise active sessions.

### Weaknesses & Architectural Risks (Action Required)
1. **Middleware Ordering Risk:** The `ResolveTenantContext` relies heavily on the JWT claims being authenticated. If route groups accidentally place `tenant.resolve` before `tm.jwt.auth`, an attacker could potentially forge contexts. *Recommendation:* Enforce a strict middleware group (e.g., `api.corp`) that groups these safely.
2. **Missing Rate Limiting on 2FA:** While `throttle:auth` is on the login endpoint, the `/2fa/verify` endpoint needs strict independent throttling to prevent brute-forcing 6-digit codes.
3. **IDOR Potential (Insecure Direct Object Reference):** When updating/deleting resources (e.g., `Branches`, `Departments`), the Controllers MUST ensure the requested entity belongs to the `corporation_id` of the current tenant. 
   - *Example Fix:* `Branch::where('corporation_id', app('tenant.corporation')->id)->where('uuid', $uuid)->firstOrFail()`. If the developer uses just `Branch::where('uuid', $uuid)`, a user from Corp A could modify Corp B's branch.
4. **Mass Assignment Risk:** Models like `EmployeeProfile` use `$fillable` (good), but developers must ensure fields like `corporation_id` cannot be overridden via `EmployeeProfile::update($request->validated())`.

---

## 10. RESPONSE ARCHITECTURE

- **`ApiResponse` Trait:** Enforces a rigid JSON envelope.
- **Format:**
  ```json
  {
    "success": true|false,
    "message": "Human readable message",
    "data": { ... },
    "errors": null | { "field": ["error message"] },
    "meta": null | { "pagination": { ... } }
  }
  ```
- **Resources:** Eloquent Collections are mapped to API Resources (`BranchResource`, `UserResource`) to ensure internal data (IDs, pivot data, hidden fields) never leaks to the frontend.

---

## 11. CODEBASE QUALITY REVIEW

- **Positives:** 
  - Controllers are incredibly clean and adhere perfectly to the single-responsibility principle. 
  - The use of Enums (`SystemRole`, `SystemPermission`) is a modern PHP 8.1+ best practice that prevents string-typo bugs.
  - Action classes (`IssueJwtAction`) prevent the `AuthService` from becoming bloated.
- **Technical Debt & Concerns:**
  - **Exception Handling:** There isn't a centralized `render` override in `bootstrap/app.php` (or `Exceptions/Handler.php`) for converting generic Exceptions into the standardized `ApiResponse` format. Unhandled exceptions might return standard Laravel HTML/JSON error stacks instead of the strict envelope format.
  - **Spatie Overhead:** While setting `setPermissionsTeamId` is clever, Spatie still hits the cache/DB frequently. Under extremely high load, pre-loading permissions into the JWT payload might be necessary.

---

## 12. COMPLETE FEATURE FLOW (Example: Department Management)

### Flow: Create Department
1. **Client sends:** `POST /api/v1/corp/departments`
2. **Middleware:** Authenticates JWT -> Resolves Tenant -> Checks `departments.create` permission.
3. **Controller:** `DepartmentController@store` receives `CreateDepartmentRequest`.
4. **Service:** `DepartmentService@create` executes.
   - It pulls `corporation_id` from the injected `tenant.corporation`.
   - Inserts into `departments` table.
   - Records an entry in `audit_logs`.
5. **Response:** Controller returns `201 Created` with `DepartmentResource`.

*This architecture enforces security completely horizontally. A developer writing a new `FeatureService` physically cannot query cross-tenant data if they follow the established pattern of utilizing `app('tenant.corporation')->id` rather than trusting client inputs.*
