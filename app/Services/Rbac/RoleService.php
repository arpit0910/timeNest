<?php

declare(strict_types=1);

namespace App\Services\Rbac;

use App\Enums\SystemPermission;
use App\Models\Rbac\Role;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleService
{
    /**
     * List roles visible to this organization.
     * Returns global roles (read-only) + org-specific roles (manageable).
     */
    public function list(int $organizationId, int $perPage = 20): LengthAwarePaginator
    {
        return Role::where(function ($q) use ($organizationId) {
                $q->whereNull('organization_id')         // global roles
                  ->orWhere('organization_id', $organizationId); // org roles
            })
            ->with('permissions')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * List ALL roles across the platform.
     * Platform admin use only.
     */
    public function listAll(int $perPage = 20): LengthAwarePaginator
    {
        return Role::with(['permissions'])
            ->orderByRaw('organization_id IS NOT NULL')
            ->orderBy('sort_order')
            ->paginate($perPage);
    }

    /**
     * Find a single role by UUID.
     * For org context: must be global or belong to this org.
     * For platform context: any role.
     */
    public function findByUuid(string $uuid, ?int $organizationId = null): Role
    {
        $query = Role::with('permissions')->where('uuid', $uuid);

        if ($organizationId !== null) {
            $query->where(function ($q) use ($organizationId) {
                $q->whereNull('organization_id')
                  ->orWhere('organization_id', $organizationId);
            });
        }

        return $query->firstOrFail();
    }

    /**
     * Create a new org-scoped custom role.
     * Global roles are created only via platform admin surface.
     */
    public function create(array $data, int $organizationId): Role
    {
        return DB::transaction(function () use ($data, $organizationId): Role {
            return Role::create([
                'uuid'            => (string) Str::uuid(),
                'name'            => $data['name'],
                'organization_id' => $organizationId,
                'guard_name'      => 'api',
                'is_system_role'  => false,
                'sort_order'      => $data['sort_order'] ?? 99,
            ]);
        });
    }

    /**
     * Create a global platform role.
     * Only callable from platform admin context (organization_id = null).
     */
    public function createGlobal(array $data, User $actor): Role
    {
        if (!$actor->hasAnyRole(['app_director', 'app_super_admin'])) {
            throw new \RuntimeException('Only platform directors and super admins can create global roles.');
        }

        return DB::transaction(function () use ($data): Role {
            return Role::create([
                'uuid'            => (string) Str::uuid(),
                'name'            => $data['name'],
                'organization_id' => null,
                'guard_name'      => 'api',
                'is_system_role'  => $data['is_system_role'] ?? false,
                'sort_order'      => $data['sort_order'] ?? 99,
            ]);
        });
    }

    /**
     * Update a role's metadata (name, sort_order).
     * Org users cannot update global roles.
     */
    public function update(Role $role, array $data, ?int $organizationId = null): Role
    {
        // SECURITY RULE 1: org users cannot touch global roles
        if ($organizationId !== null && $role->organization_id === null) {
            throw new \RuntimeException('Global roles cannot be modified by organizations.');
        }

        // SECURITY RULE 4: org users cannot touch other orgs' roles
        if ($organizationId !== null && $role->organization_id !== null
            && $role->organization_id !== $organizationId) {
            throw new \RuntimeException('Access denied to this role.');
        }

        return DB::transaction(function () use ($role, $data): Role {
            $role->update([
                'name'       => $data['name'] ?? $role->name,
                'sort_order' => $data['sort_order'] ?? $role->sort_order,
            ]);

            return $role->refresh()->load('permissions');
        });
    }

    /**
     * Delete a role.
     * System roles and global roles cannot be deleted by org users.
     * Before deleting, reassign members holding this role if
     * a fallback_role_uuid is provided.
     */
    public function delete(Role $role, ?int $organizationId = null, ?string $fallbackRoleUuid = null): void
    {
        // SECURITY RULE 2: system roles cannot be deleted
        if ($role->is_system_role) {
            throw new \RuntimeException('System roles cannot be deleted.');
        }

        // SECURITY RULE 1: org users cannot delete global roles
        if ($organizationId !== null && $role->organization_id === null) {
            throw new \RuntimeException('Global roles cannot be deleted by organizations.');
        }

        DB::transaction(function () use ($role, $fallbackRoleUuid): void {
            // If a fallback role is provided, reassign all users holding this role
            if ($fallbackRoleUuid !== null) {
                $fallbackRole = Role::where('uuid', $fallbackRoleUuid)->firstOrFail();

                // Reassign via Spatie's model_has_roles table
                DB::table('model_has_roles')
                    ->where('role_id', $role->id)
                    ->update(['role_id' => $fallbackRole->id]);
            }

            $role->delete();
        });
    }

    /**
     * Sync permissions on a role.
     *
     * SECURITY RULE 3: privilege escalation prevention.
     * SECURITY RULE 5: atomic sync.
     * SECURITY RULE 6: self-lockout prevention.
     *
     * @param array<string> $permissionNames  Array of permission name strings
     * @param User $actor  The user performing this action
     * @param bool $isPlatformAdmin  Exempt from escalation check if true
     */
    public function syncPermissions(
        Role $role,
        array $permissionNames,
        User $actor,
        bool $isPlatformAdmin = false,
        ?int $organizationId = null
    ): Role {
        // SECURITY RULE 1: org users cannot assign permissions to global roles
        if ($organizationId !== null && $role->organization_id === null) {
            throw new \RuntimeException('Global role permissions cannot be modified by organizations.');
        }

        // SECURITY RULE: Only platform directors and super admins can assign permissions to global roles
        if ($role->organization_id === null && !$actor->hasAnyRole(['app_director', 'app_super_admin'])) {
            throw new \RuntimeException('Only platform directors and super admins can assign permissions to global roles.');
        }

        if (!$isPlatformAdmin) {
            // SECURITY RULE 3: actor cannot grant permissions they don't hold
            $actorPermissions = $actor->getAllPermissions()->pluck('name')->toArray();
            $disallowed = array_diff($permissionNames, $actorPermissions);

            if (!empty($disallowed)) {
                throw new \RuntimeException(
                    'Permission escalation detected. You cannot assign permissions you do not hold: '
                    . implode(', ', $disallowed)
                );
            }

            // SECURITY RULE 6: prevent self-lockout
            // If the actor holds this role, ensure roles.view and roles.manage
            // are not being removed
            $actorHoldsThisRole = $actor->hasRole($role->name);
            if ($actorHoldsThisRole) {
                $criticalPermissions = [
                    SystemPermission::ROLES_VIEW->value,
                    SystemPermission::ROLES_ASSIGN_PERMISSIONS->value,
                ];
                foreach ($criticalPermissions as $critical) {
                    if (!in_array($critical, $permissionNames)) {
                        throw new \RuntimeException(
                            'You cannot remove critical role management permissions from a role you currently hold.'
                        );
                    }
                }
            }
        }

        return DB::transaction(function () use ($role, $permissionNames): Role {
            // SECURITY RULE 5: atomic sync — removes old, adds new
            $role->syncPermissions($permissionNames);

            return $role->refresh()->load('permissions');
        });
    }

    /**
     * List all available permissions.
     * Used by frontend to populate the permission assignment UI.
     * For org context: excludes platform.* permissions.
     */
    public function listPermissions(bool $isPlatformAdmin = false): Collection
    {
        $cases = SystemPermission::cases();

        if (!$isPlatformAdmin) {
            $cases = array_filter(
                $cases,
                fn($case) => !str_starts_with($case->value, 'platform.')
            );
        }

        // Group by prefix for UI rendering
        $grouped = collect($cases)->groupBy(function ($case) {
            return explode('.', $case->value)[0];
        });

        return $grouped->map(function ($permissions, $group) {
            return [
                'group'       => $group,
                'permissions' => $permissions->map(fn($p) => [
                    'name'  => $p->value,
                    'label' => $p->name,
                ])->values(),
            ];
        })->values();
    }
}
