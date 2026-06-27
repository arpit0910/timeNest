<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * All system-defined roles.
 *
 * Platform roles: global administrators managing the SaaS platform itself.
 * Organization roles: tenant-scoped, generic permission-tier roles.
 *
 * Department context is NOT part of the role — it is stored as department_id
 * on the organization_memberships table. Roles like HEAD and DEPARTMENT_ADMIN
 * require a department_id to be meaningful.
 *
 * These are system roles (is_system_role=true, organization_id=null).
 * Organizations cannot delete or rename system roles.
 */
enum SystemRole: string
{
    // ─── Platform Roles ──────────────────────────────────────────
    case APP_DIRECTOR    = 'app_director';    // Product owner / TimeNest founder
    case APP_SUPER_ADMIN = 'app_super_admin'; // Trusted internal staff
    case APP_ADMIN       = 'app_admin';       // Internal operations/admin team
    case APP_SUPPORT     = 'app_support';     // Customer support agents
    case APP_AUDITOR     = 'app_auditor';     // Internal compliance/audit observer

    // ─── Organization Roles: Org-wide administration ─────────────
    case DIRECTOR    = 'director';     // Org creator. Full control. Billing access.
    case SUPER_ADMIN = 'super_admin';  // Full org management. No billing.
    case ADMIN       = 'admin';        // General administration. Settings, members, policies.

    // ─── Organization Roles: Department-scoped authority ──────────
    case HEAD             = 'head';             // Leads a department. Manages its people and workflows.
    case DEPARTMENT_ADMIN = 'department_admin';  // Admin-level within a department only.

    // ─── Organization Roles: Generic management ──────────────────
    case MANAGER   = 'manager';    // Manages a team. Handles approvals.
    case TEAM_LEAD = 'team_lead';  // Senior member with limited oversight.

    // ─── Organization Roles: Workers ─────────────────────────────
    case EMPLOYEE   = 'employee';   // Standard full-time member.
    case INTERN     = 'intern';     // Temporary, restricted access.
    case CONTRACTOR = 'contractor'; // External/project-based, limited access.

    // ─── Organization Roles: Observers ───────────────────────────
    case VIEWER = 'viewer'; // Read-only. Auditors, board observers.

    /**
     * Returns true if this role is a platform-level (app) role.
     */
    public function isPlatformRole(): bool
    {
        return in_array($this, self::platformRoles(), true);
    }

    /**
     * Returns true if this role is an org-level role.
     */
    public function isOrgRole(): bool
    {
        return !$this->isPlatformRole();
    }

    /**
     * Alias for isOrgRole() — backward compatibility.
     */
    public function isOrganizationRole(): bool
    {
        return $this->isOrgRole();
    }

    /**
     * Returns true if this role requires a department_id to be meaningful.
     */
    public function isDepartmentScoped(): bool
    {
        return in_array($this, [
            self::HEAD,
            self::DEPARTMENT_ADMIN,
        ]);
    }

    /**
     * Returns a human-readable label for display.
     */
    public function label(): string
    {
        return match($this) {
            self::APP_DIRECTOR     => 'App Director',
            self::APP_SUPER_ADMIN  => 'App Super Admin',
            self::APP_ADMIN        => 'App Admin',
            self::APP_SUPPORT      => 'Support Agent',
            self::APP_AUDITOR      => 'App Auditor',
            self::DIRECTOR         => 'Director',
            self::SUPER_ADMIN      => 'Super Administrator',
            self::ADMIN            => 'Administrator',
            self::HEAD             => 'Department Head',
            self::DEPARTMENT_ADMIN => 'Department Administrator',
            self::MANAGER          => 'Manager',
            self::TEAM_LEAD        => 'Team Lead',
            self::EMPLOYEE         => 'Employee',
            self::INTERN           => 'Intern',
            self::CONTRACTOR       => 'Contractor',
            self::VIEWER           => 'Viewer',
        };
    }

    /**
     * Get all platform roles.
     *
     * @return self[]
     */
    public static function platformRoles(): array
    {
        return [
            self::APP_DIRECTOR,
            self::APP_SUPER_ADMIN,
            self::APP_ADMIN,
            self::APP_SUPPORT,
            self::APP_AUDITOR,
        ];
    }

    /**
     * Get all organization roles.
     *
     * @return self[]
     */
    public static function organizationRoles(): array
    {
        return [
            self::DIRECTOR,
            self::SUPER_ADMIN,
            self::ADMIN,
            self::HEAD,
            self::DEPARTMENT_ADMIN,
            self::MANAGER,
            self::TEAM_LEAD,
            self::EMPLOYEE,
            self::INTERN,
            self::CONTRACTOR,
            self::VIEWER,
        ];
    }

    /**
     * Get human-readable description.
     */
    public function description(): string
    {
        return match ($this) {
            self::APP_DIRECTOR    => 'Absolute platform owner. No restrictions.',
            self::APP_SUPER_ADMIN => 'Platform super admin. Manages organizations, billing, platform config.',
            self::APP_ADMIN       => 'Platform admin. Daily operations, support escalations.',
            self::APP_SUPPORT     => 'Read-only access to organization data for support.',
            self::APP_AUDITOR     => 'Read-only audit access across platform.',
            self::DIRECTOR        => 'Absolute owner of the organization. Full control incl. billing.',
            self::SUPER_ADMIN     => 'Full org access. Can manage all settings, users. No billing.',
            self::ADMIN           => 'Operational admin. Users, attendance, reports. Cannot touch billing.',
            self::HEAD            => 'Leads a department. Manages its people and workflows.',
            self::DEPARTMENT_ADMIN => 'Admin-level operations within a department only.',
            self::MANAGER         => 'Team-level management. Approve leaves and attendance for team.',
            self::TEAM_LEAD       => 'Senior member with limited oversight. Attendance review.',
            self::EMPLOYEE        => 'Standard self-service access.',
            self::INTERN          => 'Temporary member with restricted access.',
            self::CONTRACTOR      => 'Project-scoped, limited access.',
            self::VIEWER          => 'Read-only observer. Auditors, board observers.',
        };
    }

    /**
     * Get sort order for display purposes.
     */
    public function sortOrder(): int
    {
        return match ($this) {
            // Platform
            self::APP_DIRECTOR    => 1,
            self::APP_SUPER_ADMIN => 2,
            self::APP_ADMIN       => 3,
            self::APP_SUPPORT     => 4,
            self::APP_AUDITOR     => 5,
            // Organization
            self::DIRECTOR        => 1,
            self::SUPER_ADMIN     => 2,
            self::ADMIN           => 3,
            self::HEAD            => 4,
            self::DEPARTMENT_ADMIN => 5,
            self::MANAGER         => 6,
            self::TEAM_LEAD       => 7,
            self::EMPLOYEE        => 8,
            self::INTERN          => 9,
            self::CONTRACTOR      => 10,
            self::VIEWER          => 11,
        };
    }
}
