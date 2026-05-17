<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * All system-defined roles.
 *
 * Platform roles: global administrators managing the SaaS platform itself.
 * Corporation roles: tenant-scoped roles within a specific corporation.
 *
 * These are system roles (is_system_role=true, corporation_id=null).
 * Corporations cannot delete or rename system roles.
 */
enum SystemRole: string
{
    // ─── Platform Roles ──────────────────────────────────────────
    case AppOwner = 'app_owner';
    case AppSuperAdmin = 'app_super_admin';
    case AppAdmin = 'app_admin';
    case SupportAgent = 'support_agent';
    case Auditor = 'auditor';

    // ─── Corporation Roles ───────────────────────────────────────
    case CorpOwner = 'corporation_owner';
    case CorpSuperAdmin = 'corporation_super_admin';
    case CorpAdmin = 'corporation_admin';
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
     * Check if this is a corporation-level role.
     */
    public function isCorpRole(): bool
    {
        return in_array($this, self::corpRoles(), true);
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
     * Get all corporation roles.
     *
     * @return self[]
     */
    public static function corpRoles(): array
    {
        return [
            self::CorpOwner,
            self::CorpSuperAdmin,
            self::CorpAdmin,
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
            self::AppSuperAdmin => 'Platform super admin. Manages corporations, billing, platform config.',
            self::AppAdmin => 'Platform admin. Daily operations, support escalations.',
            self::SupportAgent => 'Read-only access to corporation data for support.',
            self::Auditor => 'Read-only audit access across platform.',
            self::CorpOwner => 'Absolute owner of the corporation. Cannot be revoked by corp admins.',
            self::CorpSuperAdmin => 'Full corp access. Can manage all settings, users, billing.',
            self::CorpAdmin => 'Operational admin. Users, attendance, reports. Cannot touch billing.',
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
            // Corporation
            self::CorpOwner => 1,
            self::CorpSuperAdmin => 2,
            self::CorpAdmin => 3,
            self::HrManager => 4,
            self::Manager => 5,
            self::Supervisor => 6,
            self::Employee => 7,
            self::Contractor => 8,
        };
    }
}
