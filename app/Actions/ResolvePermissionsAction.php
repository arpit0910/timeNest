<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\PermissionResolutionException;
use App\Models\Membership\CorpMembership;
use App\Models\Rbac\CorpRolePermissionOverride;

/**
 * Resolves the effective permission set for a user within a corporation.
 *
 * Algorithm:
 * 1. Get base permissions from the user's assigned role
 * 2. Add grant overrides (corporation-level additions)
 * 3. Remove revoke overrides (corporation-level removals)
 *
 * Result is cached by the ResolvesPermissions trait (10-min TTL).
 */
class ResolvePermissionsAction
{
    /**
     * Execute the permission resolution.
     *
     * @param int $userId
     * @param int $corpId
     * @return array<string> List of granted permission names
     *
     * @throws PermissionResolutionException
     */
    public function execute(int $userId, int $corpId): array
    {
        $membership = CorpMembership::active()
            ->where('user_id', $userId)
            ->where('corporation_id', $corpId)
            ->with('role.permissions')
            ->first();

        if (!$membership) {
            throw new PermissionResolutionException(
                "No active membership found for user {$userId} in corporation {$corpId}"
            );
        }

        // Base permissions from role
        $base = $membership->role->permissions
            ->where('is_active', true)
            ->pluck('name')
            ->toArray();

        // Corporation-level overrides for this role
        $overrides = CorpRolePermissionOverride::where('corporation_id', $corpId)
            ->where('role_id', $membership->role_id)
            ->with('permission:id,name')
            ->get();

        $grants = $overrides->where('type', 'grant')->pluck('permission.name')->toArray();
        $revokes = $overrides->where('type', 'revoke')->pluck('permission.name')->toArray();

        return array_values(array_diff(array_merge($base, $grants), $revokes));
    }
}
