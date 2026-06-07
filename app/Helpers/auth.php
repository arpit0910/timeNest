<?php

declare(strict_types=1);

use App\Auth\JwtContext;
use App\Enums\Guard;
use App\Models\Auth\User;
use App\Models\Rbac\Role;

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

if (! function_exists('current_organization_id')) {
    /**
     * Get the active organization ID from the JWT claims.
     */
    function current_organization_id(): ?int
    {
        return jwt_context()?->organizationId;
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
