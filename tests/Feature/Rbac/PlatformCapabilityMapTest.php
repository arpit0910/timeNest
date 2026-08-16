<?php

declare(strict_types=1);

namespace Tests\Feature\Rbac;

use App\Enums\PlatformTenantAccess;
use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Membership\PlatformMembership;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use App\Services\Auth\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Covers Phase 5: the blanket Gate::before wildcard was replaced by a
 * four-tier capability map. These assert the two halves that must agree —
 * what the gate authorises, and what getEffectivePermissions() projects to
 * the mobile client — because a disagreement makes features invisible even
 * though the API would serve them.
 */
class PlatformCapabilityMapTest extends TestCase
{
    use RefreshDatabase;

    /** Tier sizes are derived from SystemPermission case-name patterns. */
    private const TIER_SIZES = [
        'full' => 98,
        'provision' => 53,
        'audit' => 28,
        'read' => 22,
    ];

    private Organization $organization;

    protected function setUp(): void
    {
        parent::setUp();

        $this->organization = Organization::create([
            'legal_name' => 'Capability Map Ltd',
            'slug' => 'capability-map',
            'is_active' => true,
            'is_verified' => true,
        ]);
    }

    // ─── Gate resolution per tier ────────────────────────────────────────

    /** app_support is read-only: every *.view passes, every write is refused. */
    public function test_support_tier_reads_but_cannot_write(): void
    {
        $user = $this->platformUser(SystemRole::APP_SUPPORT);

        setPermissionsTeamId($this->organization->id);

        foreach ([
            SystemPermission::USERS_VIEW,
            SystemPermission::BRANCHES_VIEW,
            SystemPermission::ATTENDANCE_VIEW,
            SystemPermission::LEAVES_VIEW,
        ] as $allowed) {
            $this->assertTrue($user->can($allowed->value), "support should read {$allowed->value}");
        }

        foreach ([
            SystemPermission::BRANCHES_CREATE,
            SystemPermission::USERS_MANAGE,
            SystemPermission::ROLES_ASSIGN_PERMISSIONS,
            SystemPermission::ATTENDANCE_APPROVE,
            SystemPermission::ATTENDANCE_EXPORT,
        ] as $denied) {
            $this->assertFalse($user->can($denied->value), "support must not hold {$denied->value}");
        }

        setPermissionsTeamId(null);
    }

    /** app_auditor adds export on top of read, and still cannot mutate. */
    public function test_auditor_tier_reads_and_exports_but_cannot_mutate(): void
    {
        $user = $this->platformUser(SystemRole::APP_AUDITOR);

        setPermissionsTeamId($this->organization->id);

        foreach ([
            SystemPermission::ATTENDANCE_VIEW,
            SystemPermission::ATTENDANCE_EXPORT,
            SystemPermission::LEAVES_EXPORT,
            SystemPermission::USERS_EXPORT,
        ] as $allowed) {
            $this->assertTrue($user->can($allowed->value), "auditor should hold {$allowed->value}");
        }

        foreach ([
            SystemPermission::ATTENDANCE_APPROVE,
            SystemPermission::LEAVES_APPROVE,
            SystemPermission::BRANCHES_CREATE,
            SystemPermission::USERS_DELETE,
        ] as $denied) {
            $this->assertFalse($user->can($denied->value), "auditor must not hold {$denied->value}");
        }

        setPermissionsTeamId(null);
    }

    /** app_super_admin keeps unrestricted org-plane access. */
    public function test_super_admin_tier_retains_full_access(): void
    {
        $user = $this->platformUser(SystemRole::APP_SUPER_ADMIN);

        setPermissionsTeamId($this->organization->id);

        foreach ([
            SystemPermission::ATTENDANCE_APPROVE_ANY,
            SystemPermission::USERS_DELETE,
            SystemPermission::ROLES_ASSIGN_PERMISSIONS,
            SystemPermission::LEAVE_POLICY_MANAGE,
            SystemPermission::BRANCHES_DELETE,
        ] as $allowed) {
            $this->assertTrue($user->can($allowed->value), "super admin should hold {$allowed->value}");
        }

        setPermissionsTeamId(null);
    }

    /**
     * An ordinary org user must not touch the platform branch at all —
     * Gate::before has to return null so Spatie and the policies still decide.
     */
    public function test_ordinary_org_user_falls_through_to_spatie(): void
    {
        $employeeRole = Role::where('name', SystemRole::EMPLOYEE->value)->whereNull('organization_id')->firstOrFail();

        $user = User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);
        OrganizationMembership::create([
            'user_id' => $user->id,
            'organization_id' => $this->organization->id,
            'status' => 'active',
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($this->organization->id);
        $user->assignRole($employeeRole);

        $this->assertFalse($user->isPlatformAccount());
        $this->assertNull($user->platformTenantAccess());

        // Seeded employee permissions still resolve normally...
        $this->assertTrue($user->can(SystemPermission::ATTENDANCE_VIEW->value));
        // ...and nothing is granted that the role does not carry.
        $this->assertFalse($user->can(SystemPermission::USERS_DELETE->value));
        $this->assertFalse($user->can(SystemPermission::PLATFORM_FULL_ACCESS->value));

        setPermissionsTeamId(null);
    }

    // ─── Tier → permission map ───────────────────────────────────────────

    /** Each tier resolves to an exact, derived permission count. */
    public function test_each_tier_resolves_to_expected_permission_count(): void
    {
        foreach (PlatformTenantAccess::cases() as $tier) {
            $this->assertCount(
                self::TIER_SIZES[$tier->value],
                $tier->orgPermissions(),
                "tier {$tier->value} changed size — the derivation rules moved",
            );
        }
    }

    /** READ must be exactly the *.view set — nothing broader may leak in. */
    public function test_read_tier_is_exactly_the_view_set(): void
    {
        $names = array_map(
            fn (SystemPermission $p) => $p->value,
            PlatformTenantAccess::READ->orgPermissions(),
        );

        foreach ($names as $name) {
            $this->assertStringEndsWith('.view', $name, "READ tier leaked a non-view permission: {$name}");
        }
    }

    /** No tier may manufacture platform-plane authority from the org map. */
    public function test_no_tier_grants_platform_plane_abilities(): void
    {
        foreach (PlatformTenantAccess::cases() as $tier) {
            $this->assertFalse($tier->grants(SystemPermission::PLATFORM_FULL_ACCESS->value));
            $this->assertFalse($tier->grants(SystemPermission::PLATFORM_ROLES_MANAGE->value));
            $this->assertFalse($tier->grants(SystemPermission::ORGANIZATIONS_MANAGE->value));
        }
    }

    // ─── Permission projection ───────────────────────────────────────────

    /**
     * With a tenant selected the client receives platform-plane grants merged
     * with the tier's org permissions; without one, platform grants only.
     */
    public function test_projection_per_tier_with_and_without_tenant(): void
    {
        $service = app(AuthService::class);

        $cases = [
            [SystemRole::APP_SUPER_ADMIN, PlatformTenantAccess::FULL],
            [SystemRole::APP_ADMIN, PlatformTenantAccess::PROVISION],
            [SystemRole::APP_AUDITOR, PlatformTenantAccess::AUDIT],
            [SystemRole::APP_SUPPORT, PlatformTenantAccess::READ],
        ];

        foreach ($cases as [$roleCase, $expectedTier]) {
            $user = $this->platformUser($roleCase);

            $this->assertSame($expectedTier, $user->platformTenantAccess(), "{$roleCase->value} mapped to the wrong tier");

            $withoutTenant = $service->getEffectivePermissions($user, null);
            $withTenant = $service->getEffectivePermissions($user, $this->organization);

            // Without a tenant there is nothing for org permissions to apply to.
            $this->assertSame(
                $this->platformGrantsFor($roleCase),
                count($withoutTenant),
                "{$roleCase->value} without a tenant should project platform grants only",
            );

            // With a tenant the two sets are merged and de-duplicated.
            $expectedMerged = count(array_unique(array_merge(
                $this->platformGrantNamesFor($roleCase),
                array_map(fn (SystemPermission $p) => $p->value, $expectedTier->orgPermissions()),
            )));

            $this->assertSame(
                $expectedMerged,
                count($withTenant),
                "{$roleCase->value} with a tenant projected the wrong merged count",
            );

            $this->assertGreaterThanOrEqual(
                count($withoutTenant),
                count($withTenant),
                'selecting a tenant must never reduce the projection',
            );
        }
    }

    /** The projection has to agree with the gate, or the client hides working features. */
    public function test_projection_agrees_with_gate_for_read_tier(): void
    {
        $user = $this->platformUser(SystemRole::APP_SUPPORT);
        $projected = app(AuthService::class)->getEffectivePermissions($user, $this->organization);

        setPermissionsTeamId($this->organization->id);

        foreach ([SystemPermission::USERS_VIEW, SystemPermission::ATTENDANCE_VIEW] as $p) {
            $this->assertContains($p->value, $projected);
            $this->assertTrue($user->can($p->value), "projected {$p->value} but the gate denies it");
        }

        foreach ([SystemPermission::USERS_DELETE, SystemPermission::BRANCHES_CREATE] as $p) {
            $this->assertNotContains($p->value, $projected);
            $this->assertFalse($user->can($p->value), "gate allows {$p->value} but it is not projected");
        }

        setPermissionsTeamId(null);
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    /**
     * Build a platform account of the given role, granting the role exactly the
     * platform-plane permissions the real seeders give it. The base TestCase
     * does not run PlatformRolePermissionsSeeder, so the role exists but is empty.
     *
     * @return string[]
     */
    private function platformGrantNamesFor(SystemRole $roleCase): array
    {
        return match ($roleCase) {
            SystemRole::APP_SUPER_ADMIN => [SystemPermission::PLATFORM_FULL_ACCESS->value],
            SystemRole::APP_ADMIN => [
                SystemPermission::PLATFORM_ROLES_MANAGE->value,
                SystemPermission::ORGANIZATIONS_MANAGE->value,
            ],
            default => [],
        };
    }

    private function platformGrantsFor(SystemRole $roleCase): int
    {
        return count($this->platformGrantNamesFor($roleCase));
    }

    private function platformUser(SystemRole $roleCase): User
    {
        $role = Role::firstOrCreate(
            ['name' => $roleCase->value, 'guard_name' => 'api', 'organization_id' => null],
            ['tier' => 'platform', 'is_system_role' => true],
        );

        $role->syncPermissions($this->platformGrantNamesFor($roleCase));

        $user = User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);
        PlatformMembership::create(['user_id' => $user->id, 'status' => 'active']);
        $user->assignRole($role);

        return $user;
    }
}
