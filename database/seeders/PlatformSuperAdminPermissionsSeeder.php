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
 * Materialises the full permission set onto the platform root roles.
 *
 * Why this exists
 * ---------------
 * `platform.full_access` is a wildcard: the Gate::before hook in
 * AppServiceProvider short-circuits every authorization check for whoever
 * holds it, so the API already lets app_super_admin do anything. But the
 * *permission list* handed to the mobile client is a literal read of the
 * role's assigned permissions, and the client gates its UI on those strings.
 * A root admin therefore authenticated successfully and then saw an empty app.
 *
 * AuthService::getEffectivePermissions() now expands the wildcard at runtime,
 * which fixes it for any holder. This seeder additionally writes the grants to
 * the database so the role's real capability is visible to anyone inspecting
 * `role_has_permissions` — no more roles whose power is invisible in the data.
 *
 * Additive by design: it uses givePermissionTo(), never syncPermissions(), so
 * re-running is safe and never strips a customised grant. Run it after adding
 * new SystemPermission cases to bring the platform roles back up to date.
 */
class PlatformSuperAdminPermissionsSeeder extends Seeder
{
    /**
     * Platform roles that should hold every permission in the system.
     *
     * @return string[]
     */
    private function rootRoles(): array
    {
        return [
            SystemRole::APP_SUPER_ADMIN->value,
        ];
    }

    /**
     * Permissions every *other* platform role should pick up as the system
     * grows. These roles stay deliberately narrow, so only genuinely
     * cross-cutting additions belong here.
     *
     * @return array<string, SystemPermission[]>
     */
    private function supplementaryGrants(): array
    {
        return [
            SystemRole::APP_ADMIN->value => [
                SystemPermission::NOTIFICATIONS_VIEW,
                SystemPermission::NOTIFICATIONS_SEND,
                SystemPermission::NOTIFICATIONS_MANAGE,
                SystemPermission::PLATFORM_ROLES_MANAGE,
            ],
            SystemRole::APP_SUPPORT->value => [
                SystemPermission::NOTIFICATIONS_VIEW,
            ],
            SystemRole::APP_AUDITOR->value => [
                SystemPermission::NOTIFICATIONS_VIEW,
            ],
        ];
    }

    public function run(): void
    {
        // Guarantee every enum case exists as a row before granting — this
        // seeder is expected to run right after new permissions are added.
        foreach (SystemPermission::cases() as $case) {
            Permission::firstOrCreate(
                ['name' => $case->value, 'guard_name' => 'api'],
                [
                    'uuid' => (string) Str::uuid(),
                    'module' => $case->module(),
                    'action' => $case->action(),
                    'description' => $case->description(),
                ]
            );
        }

        $allPermissions = Permission::where('guard_name', 'api')->get();

        foreach ($this->rootRoles() as $roleName) {
            $role = Role::where('name', $roleName)
                ->where('guard_name', 'api')
                ->whereNull('organization_id')
                ->first();

            if (! $role) {
                $this->command->warn("Platform role '{$roleName}' not found — skipped.");

                continue;
            }

            $held = $role->permissions->pluck('name')->all();
            $missing = $allPermissions->reject(fn (Permission $p) => in_array($p->name, $held, true));

            if ($missing->isNotEmpty()) {
                $role->givePermissionTo($missing);
            }

            $this->command->info(
                "{$roleName}: granted {$missing->count()} missing permission(s), now holds {$allPermissions->count()}."
            );
        }

        foreach ($this->supplementaryGrants() as $roleName => $permissions) {
            $role = Role::where('name', $roleName)
                ->where('guard_name', 'api')
                ->whereNull('organization_id')
                ->first();

            if (! $role) {
                $this->command->warn("Platform role '{$roleName}' not found — skipped.");

                continue;
            }

            $names = array_map(fn (SystemPermission $p) => $p->value, $permissions);
            $granted = 0;

            foreach (Permission::whereIn('name', $names)->where('guard_name', 'api')->get() as $permission) {
                if (! $role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                    $granted++;
                }
            }

            $this->command->info("{$roleName}: granted {$granted} supplementary permission(s).");
        }

        // Spatie caches the permission map aggressively; without this the
        // change stays invisible until the cache expires on its own.
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Platform role permissions are up to date.');
    }
}
