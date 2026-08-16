<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * What a platform account may do *inside a tenant*.
 *
 * Replaces the blanket Gate::before wildcard, which returned true for every
 * ability and so could express only one tier. That made app_support and
 * app_auditor non-functional on org-scoped routes — both were silently granted
 * everything — and auto-granted each newly added policy method to platform
 * accounts before anyone reviewed whether that was safe.
 *
 * Each case maps to exactly one platform role (see User::platformTenantAccess()).
 */
enum PlatformTenantAccess: string
{
    case FULL      = 'full';       // app_super_admin
    case PROVISION = 'provision';  // app_admin
    case AUDIT     = 'audit';      // app_auditor
    case READ      = 'read';       // app_support

    /**
     * The organization-plane permissions this tier carries.
     *
     * Derived from SystemPermission's own groupings, never hand-listed, so a
     * newly added permission is classified automatically rather than silently
     * omitted.
     *
     * @return SystemPermission[]
     */
    public function orgPermissions(): array
    {
        return match ($this) {
            self::FULL => SystemPermission::organizationCases(),
            self::PROVISION => SystemPermission::structureAndMemberCases(),
            self::AUDIT => SystemPermission::viewAndExportCases(),
            self::READ => SystemPermission::viewCases(),
        };
    }

    /**
     * Whether this tier grants the given ability.
     *
     * Two planes are checked separately. `platform.*` abilities are a property
     * of the account itself and are resolved against the actual role assignment
     * (team-independent). Everything else is an organization-plane ability and
     * is answered from this tier's map.
     */
    public function grants(string $ability): bool
    {
        if (str_starts_with($ability, 'platform.') || $ability === SystemPermission::ORGANIZATIONS_MANAGE->value) {
            // Resolved by the caller against the real assignment — a tier never
            // manufactures platform-plane authority it was not granted.
            return false;
        }

        foreach ($this->orgPermissions() as $permission) {
            if ($permission->value === $ability) {
                return true;
            }
        }

        return false;
    }

    public function label(): string
    {
        return match ($this) {
            self::FULL => 'Full tenant access',
            self::PROVISION => 'Provisioning and member management',
            self::AUDIT => 'Read and export',
            self::READ => 'Read only',
        };
    }
}
