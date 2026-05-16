<?php

declare(strict_types=1);

namespace App\Traits;

use App\Actions\ResolvePermissionsAction;
use Illuminate\Support\Facades\Cache;

/**
 * Permission resolution and caching for corporation-scoped access control.
 *
 * Permissions are resolved per user+corporation pair:
 * 1. Base permissions from the user's role
 * 2. Plus corporation-level grant overrides
 * 3. Minus corporation-level revoke overrides
 *
 * Results are cached in the configured cache store with a 10-minute TTL.
 */
trait ResolvesPermissions
{
    /**
     * Check if a user has a specific permission within a corporation.
     *
     * @param int $userId
     * @param int $corpId
     * @param string $permission Dot-notation e.g. 'attendance.view'
     * @return bool
     */
    protected function hasPermission(int $userId, int $corpId, string $permission): bool
    {
        $permissions = $this->getResolvedPermissions($userId, $corpId);

        return in_array($permission, $permissions, true);
    }

    /**
     * Get all resolved permissions for a user within a corporation.
     *
     * @param int $userId
     * @param int $corpId
     * @return array<string>
     */
    protected function getResolvedPermissions(int $userId, int $corpId): array
    {
        $cacheKey = "perms:{$userId}:{$corpId}";

        return Cache::remember($cacheKey, 600, function () use ($userId, $corpId): array {
            return app(ResolvePermissionsAction::class)->execute($userId, $corpId);
        });
    }

    /**
     * Bust permission cache for a specific user+corporation pair.
     *
     * @param int $userId
     * @param int $corpId
     * @return void
     */
    protected function bustPermissionCache(int $userId, int $corpId): void
    {
        Cache::forget("perms:{$userId}:{$corpId}");
    }

    /**
     * Bust permission cache for all members of a role within a corporation.
     *
     * Used when role permissions or overrides change — invalidates cache
     * for every user who holds that role in the corporation.
     *
     * @param int $roleId
     * @param int $corpId
     * @param array<int> $userIds List of affected user IDs
     * @return void
     */
    protected function bustRolePermissionCache(int $roleId, int $corpId, array $userIds): void
    {
        foreach ($userIds as $userId) {
            $this->bustPermissionCache($userId, $corpId);
        }
    }
}
