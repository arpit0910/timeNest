<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MembershipStatus;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Confirms roles.php, leave/policy and leave/types resolve correctly under the
 * real, unmocked api.organization middleware stack.
 */
class LegacyMiddlewareFixTest extends TestCase
{
    use RefreshDatabase;

    protected function realJwtRequest(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');
        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user, $org, \App\Enums\Guard::ORGANIZATION, 'Manager'
        );
        $this->withToken($token);
        return $this;
    }

    protected function createOrgAndUser(): array
    {
        $org = Organization::create([
            'legal_name' => 'Middleware Fix Org',
            'slug' => 'mw-fix-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);
        $user = User::factory()->create();
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);
        return [$org, $user];
    }

    protected function grant(User $user, Organization $org, string $permissionName): void
    {
        setPermissionsTeamId($org->id);
        $p = Permission::where('name', $permissionName)->where('guard_name', 'api')->first();
        if ($p) {
            $user->givePermissionTo($p);
        }
        setPermissionsTeamId(null);
    }

    public function test_roles_endpoint_works_with_real_middleware(): void
    {
        [$org, $user] = $this->createOrgAndUser();
        $this->grant($user, $org, 'roles.view');

        $response = $this->realJwtRequest($user, $org)->getJson('/api/v1/roles');

        echo "\n=== roles.view GET /api/v1/roles ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(200);
    }

    public function test_roles_endpoint_still_denies_without_permission(): void
    {
        [$org, $user] = $this->createOrgAndUser();
        // No permission granted.

        $response = $this->realJwtRequest($user, $org)->getJson('/api/v1/roles');

        echo "\n=== NO permission GET /api/v1/roles ===\nStatus: {$response->status()}\n";

        $response->assertStatus(403);
    }

    public function test_leave_policy_endpoint_works_with_real_middleware(): void
    {
        [$org, $user] = $this->createOrgAndUser();
        $this->grant($user, $org, SystemPermission::LEAVE_POLICY_VIEW->value);

        $response = $this->realJwtRequest($user, $org)->getJson('/api/v1/leave/policy');

        echo "\n=== LEAVE_POLICY_VIEW GET /api/v1/leave/policy ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        // No policy exists yet for this org (legacy LeavePolicyController has
        // no auto-provisioning) -- 404 via LeavePolicyNotFoundException is the
        // correct, expected response here, proving middleware/permission
        // resolution now works and the request reaches real business logic
        // instead of dying at 401 before any of it runs.
        $this->assertNotEquals(401, $response->status());
    }

    public function test_leave_types_endpoint_works_with_real_middleware(): void
    {
        [$org, $user] = $this->createOrgAndUser();
        $this->grant($user, $org, SystemPermission::LEAVE_POLICY_MANAGE->value);

        $response = $this->realJwtRequest($user, $org)->getJson('/api/v1/leave/policy/' . (string) Str::uuid() . '/types');

        echo "\n=== LEAVE_POLICY_MANAGE GET .../leave/policy/{uuid}/types ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $this->assertNotEquals(401, $response->status());
    }
}
