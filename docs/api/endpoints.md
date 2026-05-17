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
