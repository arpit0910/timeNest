<?php

declare(strict_types=1);

namespace App\Services\Rbac;

use App\Enums\SystemPermission;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use App\Models\Auth\User;
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
            // Platform roles are inherited by nobody and administer the platform
            // itself — a tenant must never see or assign them. guard_name is a
            // second lock: today every role is 'api', but that is an accident of
            // seeding rather than an invariant the schema enforces.
            ->where('tier', 'organization')
            ->where('guard_name', 'api')
            ->with('permissions')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * List every role of one tier, unscoped by organization.
     * Platform admin use only.
     *
     * Caller-aware for the same reason as findByUuid(): this backs
     * GET /platform/roles, whose entire purpose is managing platform-tier
     * roles, so a hard-coded 'organization' filter would empty it. The tenant
     * -facing lister is list(), which is the one that must never return
     * platform roles.
     *
     * @param string $tier  'platform' or 'organization'
     */
    public function listAll(int $perPage = 20, string $tier = 'platform'): LengthAwarePaginator
    {
        return Role::with(['permissions'])
            ->where('tier', $tier)
            ->where('guard_name', 'api')
            ->orderByRaw('organization_id IS NOT NULL')
            ->orderBy('sort_order')
            ->paginate($perPage);
    }

    /**
     * Find a single role by UUID.
     * For org context: must be global or belong to this org.
     * For platform context: any role of the requested tier.
     *
     * The tier is caller-declared rather than inferred: PlatformRoleController
     * legitimately manages platform roles and passes 'platform', while every
     * organization-facing caller takes the default. Without it a tenant admin
     * who knew a platform role's uuid could read it here even though list()
     * no longer discloses one.
     *
     * @param string $tier  'organization' or 'platform'
     */
    public function findByUuid(string $uuid, ?int $organizationId, string $tier = 'organization'): Role
    {
        $query = Role::with('permissions')
            ->where('uuid', $uuid)
            ->where('tier', $tier);

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
        if (! $actor->can(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            throw new \RuntimeException('Only platform super admins can create global roles.');
        }

        return DB::transaction(function () use ($data): Role {
            return Role::create([
                'name'            => $data['name'],
                'organization_id' => null,
                // Explicit: the column defaults to 'organization', so without this
                // a newly created platform role would be invisible to
                // findByUuid(..., 'platform') and would leak into every tenant's
                // role list. create() below correctly relies on that default.
                'tier'            => 'platform',
                'guard_name'      => 'api',
                // Never taken from input: a system role can never be deleted, so
                // accepting this let a platform admin mint an undeletable role.
                // Matches create(), which also hard-codes false.
                'is_system_role'  => false,
                'sort_order'      => $data['sort_order'] ?? 99,
            ]);
        });
    }

    /**
     * Update a role's metadata (name, sort_order).
     * Org users cannot update global roles.
     *
     * @param User $actor  The user performing this action
     */
    public function update(Role $role, array $data, User $actor, ?int $organizationId = null): Role
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

        // SECURITY RULE 7: a global role is inherited by every organization, so
        // renaming one is a platform-wide mutation — it requires the wildcard,
        // not merely platform.roles.manage.
        if ($role->organization_id === null && ! $actor->can(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            throw new \RuntimeException('Only platform super admins can modify global roles.');
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
     *
     * @param User $actor  The user performing this action
     */
    public function delete(Role $role, User $actor, ?int $organizationId = null, ?string $fallbackRoleUuid = null): void
    {
        // SECURITY RULE 2: system roles cannot be deleted
        if ($role->is_system_role) {
            throw new \RuntimeException('System roles cannot be deleted.');
        }

        // SECURITY RULE 1: org users cannot delete global roles
        if ($organizationId !== null && $role->organization_id === null) {
            throw new \RuntimeException('Global roles cannot be deleted by organizations.');
        }

        // SECURITY RULE 7: a global role is a platform-wide mutation — deleting
        // one requires the wildcard, not merely platform.roles.manage.
        if ($role->organization_id === null && ! $actor->can(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            throw new \RuntimeException('Only platform super admins can delete global roles.');
        }

        DB::transaction(function () use ($role, $fallbackRoleUuid): void {
            // If a fallback role is provided, reassign all users holding this role
            if ($fallbackRoleUuid !== null) {
                // Reassignment is scoped to the role's own tenant. A global role's
                // assignments span every organization, so there is no correct
                // scope to move them to.
                if ($role->organization_id === null) {
                    throw new BusinessRuleViolationException(
                        'Members of a global role cannot be reassigned — the role spans every organization.',
                        'GLOBAL_ROLE_REASSIGNMENT_FORBIDDEN'
                    );
                }

                $fallbackRole = Role::where('uuid', $fallbackRoleUuid)->firstOrFail();

                // The fallback must be usable by the same tenant: either its own
                // org role, or a global role every organization inherits.
                if ($fallbackRole->organization_id !== null
                    && $fallbackRole->organization_id !== $role->organization_id) {
                    throw new BusinessRuleViolationException(
                        'The fallback role belongs to a different organization.',
                        'INVALID_FALLBACK_ROLE_SCOPE'
                    );
                }

                // Reassign via Spatie's model_has_roles table, constrained to the
                // role's own tenant so no other organization's rows are touched.
                DB::table('model_has_roles')
                    ->where('role_id', $role->id)
                    ->where('organization_id', $role->organization_id)
                    ->update(['role_id' => $fallbackRole->id]);

                // A raw DB write bypasses Spatie's cache invalidation; without
                // this the old mapping is served until the 24h TTL expires.
                app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
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
        if ($role->organization_id === null && ! $actor->can(SystemPermission::PLATFORM_FULL_ACCESS->value)) {
            throw new \RuntimeException('Only platform super admins can assign permissions to global roles.');
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
            // Matched on id, not name: hasRole('admin') resolves against the
            // ambient team, so a same-named role in another tenant false-positived.
            $actorHoldsThisRole = $actor->roles()->whereKey($role->getKey())->exists();
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

        return DB::transaction(function () use ($role, $permissionNames, $actor, $organizationId): Role {
            // SECURITY RULE 5: atomic sync — removes old, adds new
            $role->syncPermissions($permissionNames);

            $this->notifyRoleHolders($role, $actor, $organizationId);

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

    /**
     * Tell everyone holding this role that what they can do has changed.
     *
     * Scoped to the acting organization so a global role's permission change
     * doesn't fan out to every tenant on the platform at once.
     */
    private function notifyRoleHolders(Role $role, User $actor, ?int $organizationId): void
    {
        if ($organizationId === null) {
            return;
        }

        $holderIds = OrganizationMembership::query()
            ->where('organization_id', $organizationId)
            ->pluck('user_id')
            ->all();

        if ($holderIds === []) {
            return;
        }

        setPermissionsTeamId($organizationId);

        try {
            $recipients = User::whereIn('id', $holderIds)
                ->get()
                ->filter(fn (User $user) => $user->hasRole($role->name));
        } catch (\Throwable) {
            return;
        } finally {
            setPermissionsTeamId(null);
        }

        notify_users($recipients, \App\Enums\NotificationTypeEnum::ROLE_PERMISSIONS_CHANGED, [
            'body' => 'Permissions for your '.\Illuminate\Support\Str::headline($role->name).' role were updated.',
            'organization_id' => $organizationId,
            'subject' => $role,
            'actor' => $actor,
            'data' => ['role' => $role->name],
        ]);
    }
}
