<?php

declare(strict_types=1);

namespace Tests\Feature\Rbac;

use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Organization\Organization;
use App\Models\Rbac\Role;
use App\Services\Rbac\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Covers Phase 2 / 2.6: the tenant-facing role listing must never disclose
 * platform-tier roles, and roles.view must no longer reach ordinary members.
 */
class RoleListingScopeTest extends TestCase
{
    use RefreshDatabase;

    private Organization $orgA;

    private Organization $orgB;

    private RoleService $roleService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->roleService = app(RoleService::class);

        $this->orgA = Organization::create([
            'legal_name' => 'Org A Ltd', 'slug' => 'org-a', 'is_active' => true, 'is_verified' => true,
        ]);
        $this->orgB = Organization::create([
            'legal_name' => 'Org B Ltd', 'slug' => 'org-b', 'is_active' => true, 'is_verified' => true,
        ]);

        foreach ([SystemRole::APP_SUPER_ADMIN, SystemRole::APP_ADMIN] as $platformRole) {
            Role::firstOrCreate(
                ['name' => $platformRole->value, 'guard_name' => 'api', 'organization_id' => null],
                ['tier' => 'platform', 'is_system_role' => true],
            );
        }
    }

    /** The tenant lister returns no platform-tier role, whatever else it returns. */
    public function test_organization_listing_excludes_platform_roles(): void
    {
        $roles = $this->roleService->list($this->orgA->id, 200);

        $this->assertGreaterThan(0, $roles->total(), 'expected some organization roles to exist');
        $this->assertTrue(
            $roles->every(fn (Role $r) => $r->tier === 'organization'),
            'tenant role listing leaked a platform-tier role',
        );
    }

    /** Org A must not see a custom role belonging to Org B. */
    public function test_organization_listing_excludes_other_orgs_custom_roles(): void
    {
        $foreign = $this->roleService->create(['name' => 'org_b_only_role'], $this->orgB->id);

        $names = $this->roleService->list($this->orgA->id, 200)->pluck('name');

        $this->assertNotContains($foreign->name, $names->all());
    }

    /** A tenant caller cannot fetch a platform role by uuid even knowing it. */
    public function test_find_by_uuid_rejects_platform_role_for_tenant_caller(): void
    {
        $platformRole = Role::where('name', SystemRole::APP_SUPER_ADMIN->value)->firstOrFail();

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->roleService->findByUuid($platformRole->uuid, $this->orgA->id);
    }

    /** The platform lister returns platform roles — the tenant filter must not bleed into it. */
    public function test_platform_listing_returns_only_platform_roles(): void
    {
        $roles = $this->roleService->listAll(200, 'platform');

        $this->assertGreaterThan(0, $roles->total(), 'platform role management would be empty');
        $this->assertTrue($roles->every(fn (Role $r) => $r->tier === 'platform'));
    }

    /** A role created via the platform surface is platform-tier and invisible to tenants. */
    public function test_created_global_role_is_platform_tier_and_hidden_from_tenants(): void
    {
        $actor = $this->makePlatformSuperAdmin();

        $role = $this->roleService->createGlobal(['name' => 'new_global_role'], $actor);

        $this->assertSame('platform', $role->tier);
        $this->assertNotContains('new_global_role', $this->roleService->list($this->orgA->id, 200)->pluck('name')->all());
    }

    /** createGlobal must never mint an undeletable role from client input. */
    public function test_created_global_role_ignores_is_system_role_from_input(): void
    {
        $actor = $this->makePlatformSuperAdmin();

        $role = $this->roleService->createGlobal(
            ['name' => 'not_a_system_role', 'is_system_role' => true],
            $actor,
        );

        $this->assertFalse((bool) $role->is_system_role);
    }

    /** Phase 2.6: these roles cannot assign roles, so they no longer read them. */
    public function test_member_tier_roles_no_longer_hold_roles_view(): void
    {
        foreach ([SystemRole::EMPLOYEE, SystemRole::MANAGER, SystemRole::TEAM_LEAD] as $roleCase) {
            $role = Role::where('name', $roleCase->value)->whereNull('organization_id')->first();

            if ($role === null) {
                continue;
            }

            $this->assertFalse(
                $role->hasPermissionTo(SystemPermission::ROLES_VIEW->value),
                "{$roleCase->value} still holds roles.view",
            );
        }
    }

    private function makePlatformSuperAdmin(): \App\Models\Auth\User
    {
        $role = Role::where('name', SystemRole::APP_SUPER_ADMIN->value)->firstOrFail();

        // The base TestCase seeds only PlatformPermissionsSeeder and
        // OrganizationRolePermissionsSeeder, so the platform role exists but
        // carries no permissions. Grant the wildcard the tier depends on.
        $role->givePermissionTo(SystemPermission::PLATFORM_FULL_ACCESS->value);

        $user = \App\Models\Auth\User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);
        $user->assignRole($role);

        return $user;
    }
}
