<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\MembershipStatus;
use App\Enums\SystemPermission;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Live reproduction of the missing-ResolveTenantContext gap on the 4 legacy
 * route blocks in routes/api.php. Deliberately does NOT disable any
 * middleware and does NOT manually bind 'tenant.organization' -- this is
 * meant to reflect exactly what a real, unmocked request experiences.
 */
class TenantContextGapReproTest extends TestCase
{
    use RefreshDatabase;

    protected function realJwtRequest(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');
        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user, $org, \App\Enums\Guard::ORGANIZATION, 'Manager'
        );
        $this->withToken($token);
        // Deliberately NOT disabling EnsureOrganizationAccess and NOT binding
        // tenant.organization -- this is the real, unmocked middleware path.
        return $this;
    }

    protected function createOrgAndUser(string $orgName): array
    {
        $org = Organization::create([
            'legal_name' => $orgName,
            'slug' => Str::slug($orgName) . '-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);
        $user = User::factory()->create();
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);
        return [$org, $user];
    }

    public function test_leave_requests_index_with_real_unmocked_middleware(): void
    {
        // User belongs to BOTH orgs. Holds LEAVES_VIEW ONLY under Org A's team context.
        [$orgA, $user] = $this->createOrgAndUser('Org A');
        [$orgB, ] = $this->createOrgAndUser('Org B');
        $orgB->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($orgA->id);
        $perm = Permission::where('name', SystemPermission::LEAVES_VIEW->value)->where('guard_name', 'api')->first();
        $user->givePermissionTo($perm);
        setPermissionsTeamId(null);

        // Confirm the permission is genuinely NOT granted under Org B's team context.
        setPermissionsTeamId($orgB->id);
        $hasUnderB = $user->fresh()->hasPermissionTo(SystemPermission::LEAVES_VIEW->value);
        setPermissionsTeamId(null);
        echo "\nSanity check -- user has LEAVES_VIEW under Org B's team context directly: " . var_export($hasUnderB, true) . "\n";
        $this->assertFalse($hasUnderB, 'Sanity check failed -- permission should NOT be granted under Org B.');

        // Now: real JWT scoped to Org B (the tenant with NO grant), real middleware,
        // hitting the legacy /leave-requests endpoint (no permission: middleware,
        // no ResolveTenantContext to set team context OR bind tenant.organization).
        $response = $this->realJwtRequest($user, $orgB)->getJson('/api/v1/leave-requests');

        echo "\n=== LIVE REPRO: GET /api/v1/leave-requests, JWT=Org B, permission only under Org A ===\n";
        echo "Status: {$response->status()}\n";
        echo "Body: {$response->getContent()}\n";
    }

    public function test_leave_policy_show_with_real_unmocked_middleware(): void
    {
        [$orgA, $user] = $this->createOrgAndUser('Org A');
        [$orgB, ] = $this->createOrgAndUser('Org B');
        $orgB->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($orgA->id);
        $perm = Permission::where('name', SystemPermission::LEAVE_POLICY_VIEW->value)->where('guard_name', 'api')->first();
        $user->givePermissionTo($perm);
        setPermissionsTeamId(null);

        $response = $this->realJwtRequest($user, $orgB)->getJson('/api/v1/leave/policy');

        echo "\n=== LIVE REPRO: GET /api/v1/leave/policy, JWT=Org B, permission only under Org A ===\n";
        echo "Status: {$response->status()}\n";
        echo "Body: {$response->getContent()}\n";
    }

    public function test_attendance_policy_with_real_unmocked_middleware(): void
    {
        [$orgA, $user] = $this->createOrgAndUser('Org A');
        [$orgB, ] = $this->createOrgAndUser('Org B');
        $orgB->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($orgA->id);
        $perm = Permission::where('name', SystemPermission::ATTENDANCE_POLICY_VIEW->value)->where('guard_name', 'api')->first();
        if ($perm) {
            $user->givePermissionTo($perm);
        }
        setPermissionsTeamId(null);

        $response = $this->realJwtRequest($user, $orgB)->getJson('/api/v1/attendance/policy');

        echo "\n=== LIVE REPRO: GET /api/v1/attendance/policy, JWT=Org B, permission only under Org A ===\n";
        echo "Status: {$response->status()}\n";
        echo "Body: {$response->getContent()}\n";
    }

    public function test_roles_endpoint_with_real_unmocked_middleware(): void
    {
        // routes/api/v1/roles.php is required at the top level of routes/api.php
        // (not nested inside the api.organization-wrapped organization.php),
        // and uses the JWT package's own generic 'jwt.auth' middleware, not
        // this app's custom tm.jwt.auth that binds JwtContext::class.
        [$orgA, $user] = $this->createOrgAndUser('Org A');

        $response = $this->realJwtRequest($user, $orgA)->getJson('/api/v1/roles');

        echo "\n=== LIVE REPRO: GET /api/v1/roles (top-level require, generic jwt.auth) ===\n";
        echo "Status: {$response->status()}\n";
        echo "Body: {$response->getContent()}\n";
    }

    public function test_no_permission_at_all_baseline(): void
    {
        // Baseline: user has NO permission anywhere, in either org. What happens?
        [$orgA, $user] = $this->createOrgAndUser('Org A');

        $response = $this->realJwtRequest($user, $orgA)->getJson('/api/v1/leave-requests');

        echo "\n=== BASELINE: GET /api/v1/leave-requests, no permission granted anywhere ===\n";
        echo "Status: {$response->status()}\n";
        echo "Body: {$response->getContent()}\n";
    }
}
