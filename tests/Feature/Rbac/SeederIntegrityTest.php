<?php

declare(strict_types=1);

namespace Tests\Feature\Rbac;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Rbac\Role;
use Database\Seeders\OrganizationRolePermissionsSeeder;
use Database\Seeders\PlatformRolePermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use ReflectionMethod;
use Tests\TestCase;

/**
 * Guards the seeder split. Nine organization-tier roles were once defined in
 * both seeders with materially different permission sets, so which one ran last
 * silently decided a role's real authority. These assert that cannot recur.
 *
 * The base TestCase runs PlatformPermissionsSeeder and
 * OrganizationRolePermissionsSeeder only, so every test here runs the role
 * seeders explicitly — otherwise it would prove nothing about seeded state.
 */
class SeederIntegrityTest extends TestCase
{
    use RefreshDatabase;

    /** Counts after a full canonical seed run, verified against the live database. */
    private const EXPECTED_PLATFORM_COUNTS = [
        'app_super_admin' => 101,
        'app_admin' => 13,
        'app_auditor' => 16,
        'app_support' => 4,
    ];

    /**
     * Read a seeder's role→permission map without running it.
     *
     * @return array<string, mixed>
     */
    private function mapOf(string $seederClass): array
    {
        $method = new ReflectionMethod($seederClass, 'rolePermissionMap');
        $method->setAccessible(true);

        return $method->invoke(new $seederClass());
    }

    /** Runs the four role seeders in the order DatabaseSeeder uses. */
    private function seedCanonical(): void
    {
        foreach ([
            'PlatformRolesSeeder',
            'PlatformRolePermissionsSeeder',
            'OrganizationRolePermissionsSeeder',
            'NotificationPermissionsSeeder',
            'PlatformSuperAdminPermissionsSeeder',
        ] as $seeder) {
            Artisan::call('db:seed', ['--class' => $seeder, '--force' => true]);
        }
    }

    /**
     * No role may appear in both seeders. Both call the destructive
     * syncPermissions(), so any duplicate hands the outcome to seeder order.
     */
    public function test_no_role_is_defined_in_two_seeders(): void
    {
        $platform = array_keys($this->mapOf(PlatformRolePermissionsSeeder::class));
        $organization = array_keys($this->mapOf(OrganizationRolePermissionsSeeder::class));

        $overlap = array_values(array_intersect($platform, $organization));

        $this->assertSame(
            [],
            $overlap,
            'a role is defined in both seeders — the outcome now depends on seeder order',
        );
    }

    /** The platform seeder must carry only the four app_* roles. */
    public function test_platform_seeder_defines_only_platform_roles(): void
    {
        $defined = array_keys($this->mapOf(PlatformRolePermissionsSeeder::class));
        sort($defined);

        $expected = [
            SystemRole::APP_ADMIN->value,
            SystemRole::APP_AUDITOR->value,
            SystemRole::APP_SUPER_ADMIN->value,
            SystemRole::APP_SUPPORT->value,
        ];
        sort($expected);

        $this->assertSame($expected, $defined);
    }

    /**
     * super_admin is an organization role and must never carry platform-plane
     * authority, regardless of which seeders ran or in what order.
     */
    public function test_super_admin_wildcard_excludes_platform_plane_permissions(): void
    {
        $this->seedCanonical();

        $role = Role::where('name', SystemRole::SUPER_ADMIN->value)->whereNull('organization_id')->firstOrFail();

        $this->assertFalse(
            $role->hasPermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value),
            'super_admin must never hold the platform wildcard',
        );
        $this->assertFalse(
            $role->hasPermissionTo(SystemPermission::PLATFORM_ROLES_MANAGE->value),
            'super_admin must never manage global roles',
        );
        $this->assertFalse(
            $role->hasPermissionTo(SystemPermission::ORGANIZATIONS_MANAGE->value),
            'organizations.manage guards tenant provisioning — it is platform-plane',
        );
    }

    /** Seeder order must not change the outcome for any role. */
    public function test_reseeding_in_either_order_produces_identical_counts(): void
    {
        $this->seedCanonical();
        $forward = $this->currentCounts();

        // Reverse the two role seeders, then restore canonical order.
        Artisan::call('db:seed', ['--class' => 'OrganizationRolePermissionsSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'PlatformRolePermissionsSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'OrganizationRolePermissionsSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'NotificationPermissionsSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'PlatformSuperAdminPermissionsSeeder', '--force' => true]);

        $this->assertSame($forward, $this->currentCounts(), 'seeder order changed the resulting permission counts');
    }

    /** Each platform role lands on its expected size after a canonical run. */
    public function test_platform_roles_have_expected_counts_after_canonical_seed(): void
    {
        $this->seedCanonical();

        foreach (self::EXPECTED_PLATFORM_COUNTS as $name => $expected) {
            $role = Role::where('name', $name)->whereNull('organization_id')->first();

            $this->assertNotNull($role, "platform role {$name} is missing");
            $this->assertSame($expected, $role->permissions()->count(), "{$name} permission count drifted");
            $this->assertSame('platform', $role->tier, "{$name} must be platform tier");
        }
    }

    /**
     * @return array<string, int>
     */
    private function currentCounts(): array
    {
        return Role::withCount('permissions')
            ->whereNull('organization_id')
            ->orderBy('name')
            ->pluck('permissions_count', 'name')
            ->all();
    }
}
