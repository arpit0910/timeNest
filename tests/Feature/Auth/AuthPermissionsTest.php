<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthPermissionsTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrganization(string $legalName, string $slug): Organization
    {
        return Organization::create([
            'legal_name' => $legalName,
            'slug' => $slug,
            'is_active' => true,
            'is_verified' => true,
        ]);
    }

    private function assignOrgRole(User $user, Organization $organization, SystemRole $role): void
    {
        $roleModel = Role::firstOrCreate([
            'name' => $role->value,
            'guard_name' => 'api',
            'organization_id' => null,
        ]);

        OrganizationMembership::create([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'status' => MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($organization->id);
        $user->assignRole($roleModel);
        setPermissionsTeamId(null);
    }

    public function test_single_org_login_returns_permissions_and_role_label(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);
        $org = $this->makeOrganization('Acme Technologies Private Limited', 'acme-tech');
        $this->assignOrgRole($user, $org, SystemRole::ADMIN);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        fwrite(STDERR, "\n\n=== TEST 1: single-org ADMIN login ===\n" . $response->getContent() . "\n");

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'authenticated')
            ->assertJsonPath('data.role', 'admin')
            ->assertJsonPath('data.role_label', 'Administrator');

        $permissions = $response->json('data.permissions');
        $this->assertIsArray($permissions);
        $this->assertContains('users.manage', $permissions);
        $this->assertContains('leaves.approve', $permissions);
    }

    public function test_select_organization_scopes_permissions_per_org_with_no_leakage(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);
        $orgA = $this->makeOrganization('Org A Ltd', 'org-a');
        $orgB = $this->makeOrganization('Org B Ltd', 'org-b');

        $this->assignOrgRole($user, $orgA, SystemRole::ADMIN);
        $this->assignOrgRole($user, $orgB, SystemRole::EMPLOYEE);

        // Login with 2 orgs -> requires workspace selection, temp_token in `meta`.
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $loginResponse->assertStatus(403)->assertJsonPath('error_code', 'WORKSPACE_SELECTION_REQUIRED');
        $tempToken = $loginResponse->json('meta.temp_token');
        $this->assertNotEmpty($tempToken);

        // Select Org A (Admin) using the temp token.
        $selectAResponse = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', ['organization_uuid' => $orgA->uuid]);

        fwrite(STDERR, "\n\n=== TEST 2a: select-organization Org A (Admin) ===\n" . $selectAResponse->getContent() . "\n");

        $selectAResponse->assertOk()->assertJsonPath('data.role', 'admin');
        $permissionsA = $selectAResponse->json('data.permissions');
        $this->assertContains('users.manage', $permissionsA);
        $this->assertContains('leaves.approve', $permissionsA);

        $orgAAccessToken = $selectAResponse->json('data.access_token');

        // Switch to Org B (Employee) using the Org A access token.
        $switchBResponse = $this->withHeader('Authorization', "Bearer {$orgAAccessToken}")
            ->postJson('/api/v1/auth/switch-organization', ['organization_uuid' => $orgB->uuid]);

        fwrite(STDERR, "\n\n=== TEST 2b: switch-organization to Org B (Employee) ===\n" . $switchBResponse->getContent() . "\n");

        $switchBResponse->assertOk()->assertJsonPath('data.role', 'employee');
        $permissionsB = $switchBResponse->json('data.permissions');

        // Employee's real permissions present...
        $this->assertContains('attendance.view', $permissionsB);
        $this->assertContains('leaves.view', $permissionsB);
        // ...but NONE of Admin's org-A-only permissions leaked across.
        $this->assertNotContains('users.manage', $permissionsB);
        $this->assertNotContains('leaves.approve', $permissionsB);
    }

    public function test_me_endpoint_returns_own_permissions_for_a_normal_user_without_403(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);
        $org = $this->makeOrganization('Beta Corp', 'beta-corp');
        $this->assignOrgRole($user, $org, SystemRole::EMPLOYEE);

        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);
        $accessToken = $loginResponse->json('data.access_token');
        $this->assertNotEmpty($accessToken);

        $meResponse = $this->withHeader('Authorization', "Bearer {$accessToken}")
            ->getJson('/api/v1/auth/me');

        fwrite(STDERR, "\n\n=== TEST 3: GET /auth/me (Employee, non-admin) ===\n" . $meResponse->getContent() . "\n");

        $meResponse
            ->assertOk()
            ->assertJsonPath('data.role', 'employee')
            ->assertJsonPath('data.role_label', 'Employee')
            ->assertJsonPath('data.organization.uuid', $org->uuid);

        $permissions = $meResponse->json('data.permissions');
        $this->assertContains('attendance.view', $permissions);
        $this->assertNotContains('users.manage', $permissions);
    }

    public function test_user_with_no_workspace_gets_empty_permissions_without_error(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        fwrite(STDERR, "\n\n=== TEST 4: no-workspace user login ===\n" . $response->getContent() . "\n");

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'no_workspace')
            ->assertJsonPath('data.permissions', []);
    }
}
