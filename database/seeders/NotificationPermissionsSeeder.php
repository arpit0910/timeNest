<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Rbac\Permission;
use App\Models\Rbac\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Backfills the notification permissions onto roles that already exist.
 *
 * Unlike OrganizationRolePermissionsSeeder this is purely additive — it uses
 * givePermissionTo() rather than syncPermissions(), so re-running it never
 * strips permissions an organization has customised. Safe to run on a live
 * database after deploying the notifications module.
 */
class NotificationPermissionsSeeder extends Seeder
{
    /**
     * Roles allowed to broadcast an announcement to the whole organization.
     *
     * @return string[]
     */
    private function broadcastRoles(): array
    {
        return [
            SystemRole::APP_SUPER_ADMIN->value,
            SystemRole::APP_ADMIN->value,
            SystemRole::SUPER_ADMIN->value,
            SystemRole::ADMIN->value,
            SystemRole::HEAD->value,
            SystemRole::DEPARTMENT_ADMIN->value,
            SystemRole::FREELANCE_SUPER_ADMIN->value,
        ];
    }

    /**
     * Roles allowed to notify hand-picked recipients.
     *
     * @return string[]
     */
    private function targetedRoles(): array
    {
        return [
            SystemRole::APP_SUPER_ADMIN->value,
            SystemRole::APP_ADMIN->value,
            SystemRole::SUPER_ADMIN->value,
            SystemRole::ADMIN->value,
            SystemRole::HEAD->value,
            SystemRole::DEPARTMENT_ADMIN->value,
            SystemRole::MANAGER->value,
        ];
    }

    public function run(): void
    {
        // The permissions themselves may not exist yet if this runs before
        // PlatformPermissionsSeeder on an existing database.
        $permissions = [];
        foreach (
            [
                SystemPermission::NOTIFICATIONS_VIEW,
                SystemPermission::NOTIFICATIONS_SEND,
                SystemPermission::NOTIFICATIONS_MANAGE,
            ] as $permission
        ) {
            $permissions[$permission->value] = Permission::firstOrCreate(
                ['name' => $permission->value, 'guard_name' => 'api'],
                [
                    'uuid' => (string) Str::uuid(),
                    'module' => $permission->module(),
                    'action' => $permission->action(),
                    'description' => $permission->description(),
                ]
            );
        }

        $viewGrants = 0;
        $sendGrants = 0;
        $manageGrants = 0;

        // Every role gets the feed. A notification is always addressed to one
        // recipient, so withholding this only breaks that person's own inbox.
        foreach (Role::where('guard_name', 'api')->get() as $role) {
            if (! $role->hasPermissionTo($permissions[SystemPermission::NOTIFICATIONS_VIEW->value])) {
                $role->givePermissionTo($permissions[SystemPermission::NOTIFICATIONS_VIEW->value]);
                $viewGrants++;
            }

            if (in_array($role->name, $this->broadcastRoles(), true)
                && ! $role->hasPermissionTo($permissions[SystemPermission::NOTIFICATIONS_SEND->value])) {
                $role->givePermissionTo($permissions[SystemPermission::NOTIFICATIONS_SEND->value]);
                $sendGrants++;
            }

            if (in_array($role->name, $this->targetedRoles(), true)
                && ! $role->hasPermissionTo($permissions[SystemPermission::NOTIFICATIONS_MANAGE->value])) {
                $role->givePermissionTo($permissions[SystemPermission::NOTIFICATIONS_MANAGE->value]);
                $manageGrants++;
            }
        }

        $this->command->info(
            "Notification permissions backfilled — view: {$viewGrants}, send: {$sendGrants}, manage: {$manageGrants}."
        );
    }
}
