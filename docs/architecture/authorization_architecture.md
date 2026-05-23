# Authorization & RBAC Architecture

This document describes the enterprise-grade authorization and Role-Based Access Control (RBAC) system implemented in TimeNest.

## Core Principles

1.  **Centralized Enforcement**: Authorization logic is enforced at the route level via middleware stacks. Controllers are "thin" and contain no authorization branching.
2.  **Guard Isolation**: The system distinguishes between `platform` (global admin) and `corp` (tenant-scoped) contexts using JWT claims, enforced by dedicated middleware.
3.  **Type-Safe Constants**: All roles, permissions, modules, and guards are defined as PHP Enums. "Magic strings" are strictly prohibited.
4.  **Tenant Safety**: Corporation-level data is strictly isolated. The `ResolveTenantContext` middleware ensures that every request is bound to a valid, active corporation before reaching the controller.
5.  **Policy-Driven CRUD**: (Upcoming) Resource-level ownership is verified through Laravel Policies.

---

## The Authorization Lifecycle

1.  **Authentication (`jwt.auth`)**: Validates the JWT signature, expiry, and user status. Binds the `User` and `JwtContext` DTO to the container.
2.  **Guard Enforcement (`platform.access` or `corp.access`)**: Verifies that the token was issued for the correct context.
3.  **Tenant Resolution (`tenant.resolve`)**: For corporation routes, extracts the `corporation_id`, loads the model, and sets the Spatie Team ID for permission scoping.
4.  **Permission Check (`permission:{name}`)**: Verifies that the user has the required permission within the resolved context.

---

## Enums (The Source of Truth)

### `App\Enums\Guard`
Defines the authorization scope of a token:
- `Platform`: Internal platform administrators.
- `Corp`: Corporation-level users.
- `Temp`: Short-lived tokens for 2FA or workspace selection.

### `App\Enums\SystemRole`
Defines all roles in the system. Roles are divided into platform roles (e.g., `AppOwner`) and corporation roles (e.g., `CorpOwner`, `HrManager`).

### `App\Enums\SystemPermission`
Defines every granular permission following the `{module}.{action}` convention (e.g., `branches.view`, `payroll.process`).

---

## Usage Guide

### Defining Routes
Always apply the appropriate middleware stack in `routes/api.php`:

```php
// Platform Route
Route::middleware(['jwt.auth', 'platform.access'])
    ->group(function () {
        Route::get('/stats', 'StatsController@index')
            ->middleware('permission:' . SystemPermission::ReportsView->value);
    });

// Corporation Route
Route::middleware(['jwt.auth', 'corp.access', 'tenant.resolve'])
    ->group(function () {
        Route::get('/branches', 'BranchController@index')
            ->middleware('permission:' . SystemPermission::BranchesView->value);
    });
```

### Accessing Tenant in Controllers
Use the container-bound `tenant.corporation` instance:

```php
public function index()
{
    $corp = app('tenant.corporation');
    $branches = Branch::where('corporation_id', $corp->id)->get();
}
```

### Checking Permissions in Code
Use the enums with Spatie's methods:

```php
if ($user->hasPermissionTo(SystemPermission::UsersInvite->value)) {
    // ...
}
```

---

## Employee & Admin Invitation Flow

TimeNest supports a secure, multi-tenant scoped invitation flow to safely onboard administrators, managers, and employees.

### Architecture Key Aspects:

1.  **Token Security**: Tokens are generated as cryptographically secure random strings (`Str::random(40)`) and stored in the database hashed with `SHA-256`. The raw token is only sent in the email, protecting active invitations against database leaks.
2.  **Invitation Lifecycle State Machine**: Controlled by `App\Enums\InvitationStatusEnum` (Pending, Accepted, Expired, Revoked).
3.  **Scope Verification**:
    - Creation: Enforces `invitations.create` permission, and verifies the requested role is corporate-scoped (not a platform role).
    - Acceptance (Existing Users): Requires the user to authenticate. Verifies that the authenticated user's email matches the invitation email. If matching, links the existing user to the corporation via `MembershipService` and Spatie teams without creating duplicate users.
    - Acceptance (New Users): Collects user credentials, creates a pre-verified user, associates corporation membership, assigns the Spatie role, and automatically issues corporate-scoped JWT access and refresh tokens for immediate login.

