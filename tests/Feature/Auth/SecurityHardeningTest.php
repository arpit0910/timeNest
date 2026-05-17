<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
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
    private Corporation $corp1;
    private Corporation $corp2;
    private Role $appOwnerRole;
    private IssueJwtAction $issueJwtAction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->issueJwtAction = app(IssueJwtAction::class);

        // 1. Create Corporations
        $this->corp1 = Corporation::create([
            'legal_name' => 'First Corp Ltd',
            'slug' => 'first-corp',
            'is_active' => true,
            'is_verified' => true,
        ]);

        $this->corp2 = Corporation::create([
            'legal_name' => 'Second Corp Ltd',
            'slug' => 'second-corp',
            'is_active' => true,
            'is_verified' => true,
        ]);

        // 2. Create Platform Roles
        $this->appOwnerRole = Role::create([
            'name' => SystemRole::AppOwner->value,
            'guard_name' => 'api',
            'corporation_id' => null,
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
     * Verify that AppOwner can select any active corporation workspace without physical membership.
     */
    public function test_app_owner_can_select_any_corporation_without_membership(): void
    {
        $token = $this->issueJwtAction->issueTempToken($this->appOwner, 'workspace_selection');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/auth/select-corporation', [
                'corporation_uuid' => $this->corp1->uuid,
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
     * Verify that regular users cannot select a corporation they are not members of.
     */
    public function test_regular_user_cannot_select_corporation_without_membership(): void
    {
        $regularUser = User::factory()->create([
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $token = $this->issueJwtAction->issueTempToken($regularUser, 'workspace_selection');

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/auth/select-corporation', [
                'corporation_uuid' => $this->corp1->uuid,
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
     * Verify that AppOwner can call corporation APIs directly using their platform token
     * by supplying the X-Corporation-Uuid header context.
     */
    public function test_app_owner_can_access_corp_apis_directly_with_platform_token_via_header(): void
    {
        // Issue platform access token
        $token = $this->issueJwtAction->issueAccessToken($this->appOwner, null, \App\Enums\Guard::Platform, SystemRole::AppOwner->value);

        // Call corporation branch list API directly with platform token + X-Corporation-Uuid header
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->withHeader('X-Corporation-Uuid', $this->corp1->uuid)
            ->getJson('/api/v1/corp/branches');

        $response->assertOk()
            ->assertJsonPath('success', true);
    }
}
