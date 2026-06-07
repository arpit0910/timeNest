<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * All system-defined roles.
 *
 * Platform roles: global administrators managing the SaaS platform itself.
 * Organization roles: tenant-scoped roles within a specific organization.
 *
 * These are system roles (is_system_role=true, organization_id=null).
 * Organizations cannot delete or rename system roles.
 */
enum SystemRole: string
{
    // ─── Platform Roles ──────────────────────────────────────────
    case AppOwner = 'app_owner';
    case AppSuperAdmin = 'app_super_admin';
    case AppAdmin = 'app_admin';
    case SupportAgent = 'support_agent';
    case Auditor = 'auditor';

    // ─── Organization Roles ───────────────────────────────────────
    case OrganizationOwner = 'organization_owner';
    case OrganizationSuperAdmin = 'organization_super_admin';
    case OrganizationAdmin = 'organization_admin';
    case HrManager = 'hr_manager';
    case Manager = 'manager';
    case Supervisor = 'supervisor';
    case Employee = 'employee';
    case Contractor = 'contractor';

    /**
     * Check if this is a platform-level role.
     */
    public function isPlatformRole(): bool
    {
        return in_array($this, self::platformRoles(), true);
    }

    /**
     * Check if this is an organization-level role.
     */
    public function isOrganizationRole(): bool
    {
        return in_array($this, self::organizationRoles(), true);
    }

    /**
     * Get all platform roles.
     *
     * @return self[]
     */
    public static function platformRoles(): array
    {
        return [
            self::AppOwner,
            self::AppSuperAdmin,
            self::AppAdmin,
            self::SupportAgent,
            self::Auditor,
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
            self::OrganizationOwner,
            self::OrganizationSuperAdmin,
            self::OrganizationAdmin,
            self::HrManager,
            self::Manager,
            self::Supervisor,
            self::Employee,
            self::Contractor,
        ];
    }

    /**
     * Get human-readable description.
     */
    public function description(): string
    {
        return match ($this) {
            self::AppOwner => 'Absolute platform owner. No restrictions.',
            self::AppSuperAdmin => 'Platform super admin. Manages organizations, billing, platform config.',
            self::AppAdmin => 'Platform admin. Daily operations, support escalations.',
            self::SupportAgent => 'Read-only access to organization data for support.',
            self::Auditor => 'Read-only audit access across platform.',
            self::OrganizationOwner => 'Absolute owner of the organization. Cannot be revoked by org admins.',
            self::OrganizationSuperAdmin => 'Full org access. Can manage all settings, users, billing.',
            self::OrganizationAdmin => 'Operational admin. Users, attendance, reports. Cannot touch billing.',
            self::HrManager => 'HR operations: employee records, leave, attendance, onboarding.',
            self::Manager => 'Team-level management. Approve leaves and attendance for team.',
            self::Supervisor => 'Limited oversight. Attendance review only.',
            self::Employee => 'Standard self-service access.',
            self::Contractor => 'Project-scoped, limited access.',
        };
    }

    /**
     * Get sort order for display purposes.
     */
    public function sortOrder(): int
    {
        return match ($this) {
            // Platform
            self::AppOwner => 1,
            self::AppSuperAdmin => 2,
            self::AppAdmin => 3,
            self::SupportAgent => 4,
            self::Auditor => 5,
            // Organization
            self::OrganizationOwner => 1,
            self::OrganizationSuperAdmin => 2,
            self::OrganizationAdmin => 3,
            self::HrManager => 4,
            self::Manager => 5,
            self::Supervisor => 6,
            self::Employee => 7,
            self::Contractor => 8,
        };
    }
}
