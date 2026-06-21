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
    case APP_OWNER = 'app_owner';
    case APP_SUPER_ADMIN = 'app_super_admin';
    case APP_ADMIN = 'app_admin';
    case SUPPORT_AGENT = 'support_agent';
    case AUDITOR = 'auditor';

    // ─── Organization Roles ───────────────────────────────────────
    case ORGANIZATION_OWNER = 'organization_owner';
    case ORGANIZATION_SUPER_ADMIN = 'organization_super_admin';
    case ORGANIZATION_ADMIN = 'organization_admin';
    case HR_MANAGER = 'hr_manager';
    case MANAGER = 'manager';
    case SUPERVISOR = 'supervisor';
    case EMPLOYEE = 'employee';
    case CONTRACTOR = 'contractor';

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
            self::APP_OWNER,
            self::APP_SUPER_ADMIN,
            self::APP_ADMIN,
            self::SUPPORT_AGENT,
            self::AUDITOR,
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
            self::ORGANIZATION_OWNER,
            self::ORGANIZATION_SUPER_ADMIN,
            self::ORGANIZATION_ADMIN,
            self::HR_MANAGER,
            self::MANAGER,
            self::SUPERVISOR,
            self::EMPLOYEE,
            self::CONTRACTOR,
        ];
    }

    /**
     * Get human-readable description.
     */
    public function description(): string
    {
        return match ($this) {
            self::APP_OWNER => 'Absolute platform owner. No restrictions.',
            self::APP_SUPER_ADMIN => 'Platform super admin. Manages organizations, billing, platform config.',
            self::APP_ADMIN => 'Platform admin. Daily operations, support escalations.',
            self::SUPPORT_AGENT => 'Read-only access to organization data for support.',
            self::AUDITOR => 'Read-only audit access across platform.',
            self::ORGANIZATION_OWNER => 'Absolute owner of the organization. Cannot be revoked by org admins.',
            self::ORGANIZATION_SUPER_ADMIN => 'Full org access. Can manage all settings, users, billing.',
            self::ORGANIZATION_ADMIN => 'Operational admin. Users, attendance, reports. Cannot touch billing.',
            self::HR_MANAGER => 'HR operations: employee records, leave, attendance, onboarding.',
            self::MANAGER => 'Team-level management. Approve leaves and attendance for team.',
            self::SUPERVISOR => 'Limited oversight. Attendance review only.',
            self::EMPLOYEE => 'Standard self-service access.',
            self::CONTRACTOR => 'Project-scoped, limited access.',
        };
    }

    /**
     * Get sort order for display purposes.
     */
    public function sortOrder(): int
    {
        return match ($this) {
            // Platform
            self::APP_OWNER => 1,
            self::APP_SUPER_ADMIN => 2,
            self::APP_ADMIN => 3,
            self::SUPPORT_AGENT => 4,
            self::AUDITOR => 5,
            // Organization
            self::ORGANIZATION_OWNER => 1,
            self::ORGANIZATION_SUPER_ADMIN => 2,
            self::ORGANIZATION_ADMIN => 3,
            self::HR_MANAGER => 4,
            self::MANAGER => 5,
            self::SUPERVISOR => 6,
            self::EMPLOYEE => 7,
            self::CONTRACTOR => 8,
        };
    }
}
