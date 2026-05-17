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

if (! function_exists('jwt_corporation_id')) {
    /**
     * Get the active corporation ID from the JWT claims.
     */
    function jwt_corporation_id(): ?int
    {
        return jwt_context()?->corporationId;
    }
}

if (! function_exists('jwt_corporation_uuid')) {
    /**
     * Get the active corporation UUID from the JWT claims.
     */
    function jwt_corporation_uuid(): ?string
    {
        return jwt_context()?->corporationUuid;
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

if (! function_exists('jwt_is_corp')) {
    /**
     * Check if the current context is corporation-level.
     */
    function jwt_is_corp(): bool
    {
        return (bool) jwt_context()?->isCorp();
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
        $rolesTable = config('permission.table_names.roles', 'roles');
        $modelHasRolesTable = config('permission.table_names.model_has_roles', 'model_has_roles');
        $pivotRole = config('permission.column_names.role_pivot_key') ?? 'role_id';
        $teamColumn = config('permission.column_names.team_foreign_key', 'corporation_id');
        $modelKey = config('permission.column_names.model_morph_key', 'model_id');

        return Role::query()
            ->select("{$rolesTable}.*")
            ->join($modelHasRolesTable, "{$rolesTable}.id", '=', "{$modelHasRolesTable}.{$pivotRole}")
            ->where("{$modelHasRolesTable}.{$modelKey}", $user->getKey())
            ->where("{$modelHasRolesTable}.model_type", $user->getMorphClass())
            ->whereNull("{$modelHasRolesTable}.{$teamColumn}")
            ->whereNull("{$rolesTable}.{$teamColumn}")
            ->first();
    }
}

if (! function_exists('resolve_corp_role')) {
    /**
     * Resolve the user's role within a specific corporation.
     */
    function resolve_corp_role(User $user, int $corporationId): ?Role
    {
        $rolesTable = config('permission.table_names.roles', 'roles');
        $modelHasRolesTable = config('permission.table_names.model_has_roles', 'model_has_roles');
        $pivotRole = config('permission.column_names.role_pivot_key') ?? 'role_id';
        $teamColumn = config('permission.column_names.team_foreign_key', 'corporation_id');
        $modelKey = config('permission.column_names.model_morph_key', 'model_id');

        return Role::query()
            ->select("{$rolesTable}.*")
            ->join($modelHasRolesTable, "{$rolesTable}.id", '=', "{$modelHasRolesTable}.{$pivotRole}")
            ->where("{$modelHasRolesTable}.{$modelKey}", $user->getKey())
            ->where("{$modelHasRolesTable}.model_type", $user->getMorphClass())
            ->where("{$modelHasRolesTable}.{$teamColumn}", $corporationId)
            ->where(function ($query) use ($corporationId, $rolesTable, $teamColumn): void {
                $query->whereNull("{$rolesTable}.{$teamColumn}")
                    ->orWhere("{$rolesTable}.{$teamColumn}", $corporationId);
            })
            ->first();
    }
}
