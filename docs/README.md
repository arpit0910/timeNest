<p align="center">
  <h1 align="center">TimeNest</h1>
  <p align="center"><strong>Enterprise-grade Workforce Management SaaS Platform</strong></p>
</p>

<p align="center">
  Built for freelancers, freelance teams, startups, and organizations to manage attendance,
  leave, worklogs, roles, and internal communication — from one multi-tenant platform.
</p>

---

## What is TimeNest?

TimeNest is a multi-tenant SaaS platform built to manage workforce operations for
businesses of any size — a solo freelancer, a small team, or a large organization
with thousands of employees.

The current MVP focuses on **workforce and attendance management**, but this is
intentionally just the first module. TimeNest is architected as a modular business
operating platform — the same tenant/permission/data model is designed to support
future modules like projects, invoicing, payroll, and integrations without requiring
a rewrite.

**Every user runs on the same codebase, isolated by organization** — no per-client
deployments, no forked code paths. A freelancer and a 5,000-person company both run
on the same platform, just with different roles, permissions, and enabled features.

---

## Core Modules (Live)

| Module | Description |
|---|---|
| **Attendance Tracking** | Geo-fenced clock-in/clock-out with strict, flexible, and hybrid enforcement modes |
| **Leave Management** | Configurable, multi-level approval workflows |
| **Daily Worklogs** | Structured work reporting per employee |
| **Role-Based Access Control** | Granular, permission-driven — not hardcoded department roles |
| **Multi-Tenant Data Isolation** | Every record scoped strictly to its organization |
| **Authentication** | JWT-based, with optional 2FA |
| **Chat** | Real-time inter-employee and client chat (WebSocket-based) |

## Roadmap (Not Yet Live)

These are actively planned but **not available in production yet** — do not treat
as shipped features in any client-facing communication:

- Shift management
- Advanced reporting & analytics
- Facial recognition / biometric verification
- Third-party API integrations
- Payroll
- Project management tooling

---

## Architecture Principles

TimeNest is engineered as a real SaaS product, not a CRUD app. Some core decisions
baked into the codebase:

- **Permission-driven authorization, not hardcoded roles** — organization admins can
  reassign permissions freely without any code deployment. Roles are generic tiers,
  not fixed department labels.
- **Manual tenant scoping** — there is no global Eloquent scope. Every Policy class
  explicitly checks `organization_id` against the active tenant context. This is a
  deliberate tradeoff: more boilerplate, but zero risk of a global scope silently
  leaking cross-tenant data.
- **Hybrid approval hierarchy** — approvals (leave, attendance adjustments, worklogs)
  follow `reports_to` first, falling back to department head.
- **Version snapshot isolation** — policy snapshots are stamped onto records at
  submission time. Once submitted, a record is evaluated against the snapshot it was
  created under, not whatever the live policy has since changed to.
- **API-first design** — flat route structures, UUIDs (not raw IDs) in every API
  response, built to serve web, mobile, and future integrations equally.

---

## Tech Stack

**Backend**
- Laravel 12, PHP 8.1+
- MySQL
- JWT Authentication (`tymon/jwt-auth`) with optional 2FA (`pragmarx/google2fa-laravel`)
- Spatie Laravel Permission (roles/permissions)

**Frontend**
- Blade templating
- Alpine.js
- Tailwind CSS
- Vite

**Real-time Chat Microservice**
- FastAPI (Python) — separate service, shares the same MySQL database and JWT
  secret as the Laravel backend
- SQLAlchemy (async) + Alembic for chat-specific tables only
- Redis for typing indicators and future pub/sub at scale

---

## Getting Started

```bash
# Clone the repository
git clone <repo-url>
cd timenest

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# Configure your database in .env, then run migrations
php artisan migrate

# Build frontend assets
npm run dev

# Serve the application
php artisan serve
```

> The chat microservice (FastAPI) is a separate service with its own setup —
> see `/chat-service` for its README once available.

---

## Contributing

TimeNest is under active development. Architectural decisions are made
deliberately with long-term multi-tenant scalability in mind — before
proposing a change, consider whether it holds up for a single freelancer,
a 10-person team, and a 10,000-employee organization alike.

## License

Proprietary — All rights reserved.
