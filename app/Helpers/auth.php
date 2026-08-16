<?php

declare(strict_types=1);

use App\Auth\JwtContext;
use App\Enums\Guard;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Rbac\Role;
use Illuminate\Support\Facades\DB;

if (! function_exists('jwt_context')) {
    /**
     * Get the active JWT authorization context from the container.
     */
    function jwt_context(): ?JwtContext
    {
        return app()->bound(JwtContext::class) ? app(JwtContext::class) : null;
    }
}

if (! function_exists('jwt_has_context')) {
    /**
     * Check if a JWT authorization context is bound.
     */
    function jwt_has_context(): bool
    {
        return jwt_context() !== null;
    }
}

if (! function_exists('jwt_user_uuid')) {
    /**
     * Get the authenticated user's UUID from the JWT claims.
     */
    function jwt_user_uuid(): ?string
    {
        return jwt_context()?->userUuid;
    }
}

if (! function_exists('has_platform_full_access')) {
    /**
     * Whether this user holds the platform wildcard, independent of team scope.
     *
     * Spatie scopes role assignments by team (organization_id). A platform
     * account's role is assigned with a NULL team, so the moment
     * ResolveTenantContext sets the team to a specific organization, that role
     * stops resolving and the user momentarily looks unprivileged — which is
     * how a platform super admin ended up 403ing on every org-scoped route.
     *
     * Being a platform root is a property of the account, not of whichever
     * tenant is currently loaded, so this reads the platform role directly
     * (resolve_platform_role queries the pivot with a NULL team) and never
     * consults the ambient team id.
     */
    function has_platform_full_access(User $user): bool
    {
        return has_platform_permission($user, SystemPermission::PLATFORM_FULL_ACCESS->value);
    }
}

if (! function_exists('has_platform_permission')) {
    /**
     * Whether this user holds a given permission on the *platform* plane,
     * independent of team scope.
     *
     * Generalises has_platform_full_access(): the same team-independent
     * resolution, for any permission name. Spatie scopes assignments by team,
     * and a platform account's role has a NULL team, so once
     * ResolveTenantContext sets a tenant the normal path stops resolving it.
     */
    function has_platform_permission(User $user, string $permission): bool
    {
        $cacheKey = 'platform_permission_'.$user->getKey().'_'.$permission;

        if (app()->bound($cacheKey)) {
            return app($cacheKey);
        }

        $role = resolve_platform_role($user);

        $granted = $role !== null
            && $role->permissions()->where('name', $permission)->exists();

        // Also honour the permission granted straight to the user with no team.
        if (! $granted) {
            $modelHasPermissions = config('permission.table_names.model_has_permissions', 'model_has_permissions');
            $permissionsTable = config('permission.table_names.permissions', 'permissions');
            $pivotPermission = config('permission.column_names.permission_pivot_key') ?? 'permission_id';
            $teamColumn = config('permission.column_names.team_foreign_key', 'organization_id');
            $modelKey = config('permission.column_names.model_morph_key', 'model_id');

            $granted = DB::table($modelHasPermissions)
                ->join($permissionsTable, "{$permissionsTable}.id", '=', "{$modelHasPermissions}.{$pivotPermission}")
                ->where("{$modelHasPermissions}.{$modelKey}", $user->getKey())
                ->where("{$modelHasPermissions}.model_type", $user->getMorphClass())
                ->whereNull("{$modelHasPermissions}.{$teamColumn}")
                ->where("{$permissionsTable}.name", $permission)
                ->exists();
        }

        app()->instance($cacheKey, $granted);

        return $granted;
    }
}

if (! function_exists('current_organization_id')) {
    /**
     * Get the active organization's internal ID.
     *
     * The JWT only carries the organization *uuid* — internal ids are never
     * exposed in a token — so this reads the Organization that
     * ResolveTenantContext bound to the container, and only falls back to a
     * uuid lookup when that middleware hasn't run (e.g. a FormRequest resolved
     * outside the organization stack).
     */
    function current_organization_id(): ?int
    {
        $organization = tenant_organization();

        if ($organization !== null) {
            return (int) $organization->id;
        }

        $uuid = jwt_context()?->organizationUuid;

        if ($uuid === null) {
            return null;
        }

        return \App\Models\Organization\Organization::where('uuid', $uuid)->value('id');
    }
}

if (! function_exists('current_organization_uuid')) {
    /**
     * Get the active organization UUID from the JWT claims.
     */
    function current_organization_uuid(): ?string
    {
        return jwt_context()?->organizationUuid;
    }
}

if (! function_exists('jwt_role')) {
    /**
     * Get the active role from the JWT claims.
     */
    function jwt_role(): ?string
    {
        return jwt_context()?->role;
    }
}

if (! function_exists('jwt_guard')) {
    /**
     * Get the active guard from the JWT claims.
     */
    function jwt_guard(): ?Guard
    {
        return jwt_context()?->guard;
    }
}

if (! function_exists('jwt_is_platform')) {
    /**
     * Check if the current context is platform-level.
     */
    function jwt_is_platform(): bool
    {
        return (bool) jwt_context()?->isPlatform();
    }
}

if (! function_exists('is_organization_context')) {
    /**
     * Check if the current context is organization-level.
     */
    function is_organization_context(): bool
    {
        return (bool) jwt_context()?->isOrganization();
    }
}

if (! function_exists('jwt_is_temp')) {
    /**
     * Check if the current context is a temporary token.
     */
    function jwt_is_temp(): bool
    {
        return (bool) jwt_context()?->isTemp();
    }
}

if (! function_exists('resolve_platform_role')) {
    /**
     * Resolve the user's platform role.
     */
    function resolve_platform_role(User $user): ?Role
    {
        $cacheKey = 'platform_role_' . $user->id;

        if (app()->bound($cacheKey)) {
            return app($cacheKey);
        }

        $rolesTable = config('permission.table_names.roles', 'roles');
        $modelHasRolesTable = config('permission.table_names.model_has_roles', 'model_has_roles');
        $pivotRole = config('permission.column_names.role_pivot_key') ?? 'role_id';
        $teamColumn = config('permission.column_names.team_foreign_key', 'organization_id');
        $modelKey = config('permission.column_names.model_morph_key', 'model_id');

        $role = Role::query()
            ->select("{$rolesTable}.*")
            ->join($modelHasRolesTable, "{$rolesTable}.id", '=', "{$modelHasRolesTable}.{$pivotRole}")
            ->where("{$modelHasRolesTable}.{$modelKey}", $user->getKey())
            ->where("{$modelHasRolesTable}.model_type", $user->getMorphClass())
            ->whereNull("{$modelHasRolesTable}.{$teamColumn}")
            ->whereNull("{$rolesTable}.{$teamColumn}")
            ->first();

        app()->instance($cacheKey, $role);

        return $role;
    }
}

if (! function_exists('resolve_organization_role')) {
    /**
     * Resolve the user's role within a specific organization.
     */
    function resolve_organization_role(User $user, int $organizationId): ?Role
    {
        $cacheKey = "org_role_{$user->id}_{$organizationId}";

        if (app()->bound($cacheKey)) {
            return app($cacheKey);
        }

        $rolesTable = config('permission.table_names.roles', 'roles');
        $modelHasRolesTable = config('permission.table_names.model_has_roles', 'model_has_roles');
        $pivotRole = config('permission.column_names.role_pivot_key') ?? 'role_id';
        $teamColumn = config('permission.column_names.team_foreign_key', 'organization_id');
        $modelKey = config('permission.column_names.model_morph_key', 'model_id');

        $role = Role::query()
            ->select("{$rolesTable}.*")
            ->join($modelHasRolesTable, "{$rolesTable}.id", '=', "{$modelHasRolesTable}.{$pivotRole}")
            ->where("{$modelHasRolesTable}.{$modelKey}", $user->getKey())
            ->where("{$modelHasRolesTable}.model_type", $user->getMorphClass())
            ->where("{$modelHasRolesTable}.{$teamColumn}", $organizationId)
            ->where(function ($query) use ($organizationId, $rolesTable, $teamColumn): void {
                $query->whereNull("{$rolesTable}.{$teamColumn}")
                    ->orWhere("{$rolesTable}.{$teamColumn}", $organizationId);
            })
            ->first();

        app()->instance($cacheKey, $role);

        return $role;
    }
}
