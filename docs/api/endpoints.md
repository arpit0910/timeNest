# TimeNest API Documentation

## Authentication (`/api/v1/auth`)

All routes (except login/register/refresh) require a Bearer token in the `Authorization` header.

### 1. Register
- **Endpoint**: `POST /register`
- **Body**: `name`, `email`, `password`, `password_confirmation`
- **Response**: User object with message to verify email.

### 2. Login
- **Endpoint**: `POST /login`
- **Body**: `email`, `password`
- **Response**: 
  - If single workspace: Returns `access_token` and `refresh_token` (Corp-guard).
  - If multiple workspaces: Returns `temp_token` and `requires_workspace_selection: true`.
  - If platform admin: Returns `access_token` and `refresh_token` (Platform-guard).

### 3. Refresh Token
- **Endpoint**: `POST /refresh`
- **Body**: `refresh_token` (raw string)
- **Response**: New `access_token` and `refresh_token` pair. (Old refresh token is revoked).

### 4. Get Profile
- **Endpoint**: `GET /me`
- **Requires**: JWT Authentication
- **Response**: Current authenticated user's profile.

### 5. Select Workspace
- **Endpoint**: `POST /select-corporation`
- **Requires**: Temp token (from login) or standard access token.
- **Body**: `corporation_uuid`
- **Response**: `access_token` and `refresh_token` scoped strictly to that corporation.

---

## Platform Administration (`/api/v1/platform`)
*Requires platform-guard JWT (e.g., `app_owner`, `app_super_admin`).*

### 1. Corporations
- **List**: `GET /corporations`
- **Provision**: `POST /corporations` (requires `legal_name`, optional `hq_name`, etc.)
- **View**: `GET /corporations/{uuid}`
- **Update**: `PUT /corporations/{uuid}`

---

## Corporation Workspace (`/api/v1/corp`)
*Requires corp-guard JWT and appropriate permissions (checked via `rbac:*` middleware).*

### 1. Branches
*Permissions required: `branches.view`, `branches.create`, etc.*
- **List**: `GET /branches`
- **Create**: `POST /branches` (requires `name`)
- **Update**: `PUT /branches/{uuid}`
- **Delete**: `DELETE /branches/{uuid}`

### 2. Departments
*Permissions required: `departments.view`, `departments.create`, etc.*
- **List**: `GET /departments`
- **Create**: `POST /departments` (requires `name`)
- **Update**: `PUT /departments/{uuid}`
- **Delete**: `DELETE /departments/{uuid}`

### 3. Memberships
*Permissions required: `users.view`, `users.manage`, `users.delete`.*
- **List**: `GET /memberships`
- **Add**: `POST /memberships` (requires `user_id`, `role_id`)
- **Deactivate**: `DELETE /memberships/{uuid}`
