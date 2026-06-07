<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\PlatformMembership;
use App\Models\Rbac\Role;
use App\Actions\IssueJwtAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    private User $appOwner;
    private Organization $organization1;
    private Organization $organization2;
    private Role $appOwnerRole;
    private IssueJwtAction $issueJwtAction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->issueJwtAction = app(IssueJwtAction::class);

        // 1. Create organizations
        $this->organization1 = Organization::create([
            'legal_name' => 'First Organization Ltd',
            'slug' => 'first-organization',
            'is_active' => true,
            'is_verified' => true,
        ]);

        $this->organization2 = Organization::create([
            'legal_name' => 'Second Organization Ltd',
            'slug' => 'second-organization',
            'is_active' => true,
            'is_verified' => true,
        ]);

        // 2. Create Platform Roles
        $this->appOwnerRole = Role::create([
            'name' => SystemRole::AppOwner->value,
            'guard_name' => 'api',
            'organization_id' => null,
            'is_system_role' => true,
        ]);

        // 3. Create platform owner user
        $this->appOwner = User::factory()->create([
            'email' => 'app.owner@timenest.internal',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        PlatformMembership::create([
            'user_id' => $this->appOwner->id,
            'status' => 'active',
        ]);

        $this->appOwner->assignRole($this->appOwnerRole);
    }

    /**
     * Verify that AppOwner can select any active organization workspace without physical membership.
     */
    public function test_app_owner_can_select_any_organization_without_membership(): void
    {
        $token = $this->issueJwtAction->issueTempToken($this->appOwner, 'workspace_selection');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->organization1->uuid,
            ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.role', SystemRole::AppOwner->value)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'refresh_token',
                    'token_type',
                    'expires_in',
                    'role',
                ],
            ]);
    }

    /**
     * Verify that regular users cannot select a organization they are not members of.
     */
    public function test_regular_user_cannot_select_organization_without_membership(): void
    {
        $regularUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $token = $this->issueJwtAction->issueTempToken($regularUser, 'workspace_selection');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->organization1->uuid,
            ]);

        $response->assertForbidden();
    }

    /**
     * Verify Gate::before gives root bypass to AppOwner on any capability.
     */
    public function test_gate_before_gives_root_bypass_to_app_owner(): void
    {
        $this->assertTrue(Gate::forUser($this->appOwner)->allows('random.ability.name'));
        $this->assertTrue(Gate::forUser($this->appOwner)->allows('branches.create'));
    }

    /**
     * Verify regular users do not bypass Gate::before.
     */
    public function test_regular_user_does_not_bypass_gate_before(): void
    {
        $regularUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $this->assertFalse(Gate::forUser($regularUser)->allows('random.ability.name'));
    }

    /**
     * Verify that AppOwner can call organization APIs directly using their platform token
     * by supplying the X-Organization-Uuid header context.
     */
    public function test_app_owner_can_access_organization_apis_directly_with_platform_token_via_header(): void
    {
        // Issue platform access token
        $token = $this->issueJwtAction->issueAccessToken($this->appOwner, null, \App\Enums\Guard::Platform, SystemRole::AppOwner->value);

        // Call organization branch list API directly with platform token + X-Organization-Uuid header
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->withHeader('X-Organization-Uuid', $this->organization1->uuid)
            ->getJson('/api/v1/organization/branches');

        $response->assertOk()
            ->assertJsonPath('success', true);
    }
}
