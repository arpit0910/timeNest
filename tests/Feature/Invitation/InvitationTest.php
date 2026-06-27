<?php

declare(strict_types=1);

namespace Tests\Feature\Invitation;

use App\Actions\IssueJwtAction;
use App\Enums\InvitationStatusEnum;
use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Events\InvitationCreated;
use App\Events\InvitationAccepted;
use App\Events\InvitationRevoked;
use App\Mail\InvitationMail;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Invitation\Invitation;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use Database\Seeders\PlatformPermissionsSeeder;
use Database\Seeders\PlatformRolePermissionsSeeder;
use Database\Seeders\PlatformRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    private Organization $organizationA;
    private Organization $organizationB;
    private User $adminA;
    private User $adminB;
    private Role $adminRole;
    private Role $employeeRole;
    private string $tokenA;
    private string $tokenB;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Seed RBAC
        $this->seed(PlatformPermissionsSeeder::class);
        $this->seed(PlatformRolesSeeder::class);
        $this->seed(PlatformRolePermissionsSeeder::class);

        // 2. Resolve roles
        $this->adminRole = Role::where('name', SystemRole::ADMIN->value)->firstOrFail();
        $this->employeeRole = Role::where('name', SystemRole::EMPLOYEE->value)->firstOrFail();

        // 3. Create organizations
        $this->organizationA = Organization::create([
            'legal_name' => 'Organization A Inc',
            'slug' => 'organization-a',
            'is_active' => true,
            'is_verified' => true,
        ]);

        $this->organizationB = Organization::create([
            'legal_name' => 'Organization B Inc',
            'slug' => 'organization-b',
            'is_active' => true,
            'is_verified' => true,
        ]);

        // 4. Create organization Admins
        $this->adminA = User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);
        $this->adminB = User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);

        // 5. Attach Admin A to organization A
        OrganizationMembership::create([
            'user_id' => $this->adminA->id,
            'organization_id' => $this->organizationA->id,
            'status' => MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);
        setPermissionsTeamId($this->organizationA->id);
        $this->adminA->assignRole($this->adminRole);

        // 6. Attach Admin B to organization B
        OrganizationMembership::create([
            'user_id' => $this->adminB->id,
            'organization_id' => $this->organizationB->id,
            'status' => MembershipStatus::ACTIVE,
            'joined_at' => now(),
        ]);
        setPermissionsTeamId($this->organizationB->id);
        $this->adminB->assignRole($this->adminRole);

        setPermissionsTeamId(null);

        // 7. Issue Auth Tokens
        $issueJwtAction = app(IssueJwtAction::class);
        $this->tokenA = $issueJwtAction->issueAccessToken($this->adminA, $this->organizationA, \App\Enums\Guard::ORGANIZATION, SystemRole::ADMIN->value);
        $this->tokenB = $issueJwtAction->issueAccessToken($this->adminB, $this->organizationB, \App\Enums\Guard::ORGANIZATION, SystemRole::ADMIN->value);
    }

    private function headers(string $token, Organization $organization): array
    {
        return [
            'Authorization' => "Bearer {$token}",
            'X-Organization-Uuid' => $organization->uuid,
        ];
    }

    public function test_organization_admin_can_create_invitation(): void
    {
        Mail::fake();
        Event::fake([InvitationCreated::class]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson('/api/v1/organization/invitations', [
                'email' => 'new.employee@example.com',
                'role_uuid' => $this->employeeRole->uuid,
            ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => ['uuid', 'email', 'status', 'status_label', 'role']
            ]);

        $this->assertDatabaseHas('organization_invitations', [
            'organization_id' => $this->organizationA->id,
            'email' => 'new.employee@example.com',
            'role_id' => $this->employeeRole->id,
            'status' => InvitationStatusEnum::PENDING->value,
        ]);

        Event::assertDispatched(InvitationCreated::class);
    }

    public function test_cannot_create_invitation_for_invalid_role(): void
    {
        // Try creating with a platform-only role (e.g. AppOwner)
        $platformRole = Role::where('name', SystemRole::APP_DIRECTOR->value)->firstOrFail();

        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson('/api/v1/organization/invitations', [
                'email' => 'new.employee@example.com',
                'role_uuid' => $platformRole->uuid,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('error_code', 'INVALID_ROLE');
    }

    public function test_cannot_duplicate_active_invitation(): void
    {
        // Create first invitation
        Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'duplicate@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token123'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        // Attempt duplicate
        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson('/api/v1/organization/invitations', [
                'email' => 'duplicate@example.com',
                'role_uuid' => $this->employeeRole->uuid,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('error_code', 'DUPLICATE_INVITATION');
    }

    public function test_list_invitations_with_filters(): void
    {
        // Create pending invite
        Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'pending@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_pending'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        // Create revoked invite
        Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'revoked@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_revoked'),
            'status' => InvitationStatusEnum::REVOKED,
            'expires_at' => now()->addDays(7),
        ]);

        // List all
        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->getJson('/api/v1/organization/invitations');

        $response->assertOk()
            ->assertJsonCount(2, 'data.data');

        // Filter by status (Revoked = 4)
        $responseFiltered = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->getJson('/api/v1/organization/invitations?status=4');

        $responseFiltered->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.email', 'revoked@example.com');
    }

    public function test_show_invitation(): void
    {
        $invite = Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'show@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_show'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->getJson("/api/v1/organization/invitations/{$invite->uuid}");

        $response->assertOk()
            ->assertJsonPath('data.email', 'show@example.com');
    }

    public function test_revoke_invitation(): void
    {
        Event::fake([InvitationRevoked::class]);

        $invite = Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'revoke.me@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_revoke'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson("/api/v1/organization/invitations/{$invite->uuid}/revoke");

        $response->assertOk()
            ->assertJsonPath('data.status', InvitationStatusEnum::REVOKED->value);

        $this->assertDatabaseHas('organization_invitations', [
            'id' => $invite->id,
            'status' => InvitationStatusEnum::REVOKED->value,
            'revoked_by' => $this->adminA->id,
        ]);

        Event::assertDispatched(InvitationRevoked::class);
    }

    public function test_resend_invitation(): void
    {
        Event::fake([InvitationCreated::class]);

        $invite = Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'resend.me@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_old'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
            'resend_count' => 0,
        ]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson("/api/v1/organization/invitations/{$invite->uuid}/resend");

        $response->assertOk()
            ->assertJsonPath('data.resend_count', 1);

        $invite->refresh();
        $this->assertNotEquals(hash('sha256', 'token_old'), $invite->token);
        $this->assertEquals(1, $invite->resend_count);
        $this->assertNotNull($invite->last_resent_at);

        Event::assertDispatched(InvitationCreated::class);
    }

    public function test_validate_token_endpoint(): void
    {
        $invite = Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'validate@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtoken123'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        // Success
        $response = $this->getJson('/api/v1/invitations/validate/rawtoken123');
        $response->assertOk()
            ->assertJsonPath('data.email', 'validate@example.com')
            ->assertJsonPath('data.user_exists', false);

        // Invalid
        $responseInvalid = $this->getJson('/api/v1/invitations/validate/wrongtoken');
        $responseInvalid->assertStatus(422)
            ->assertJsonPath('error_code', 'INVALID_TOKEN');
    }

    public function test_accept_invitation_new_user(): void
    {
        Event::fake([InvitationAccepted::class]);

        $invite = Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'new.onboard@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtoken123'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->postJson('/api/v1/invitations/accept', [
            'token' => 'rawtoken123',
            'name' => 'New Onboard',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'timezone' => 'Asia/Kolkata',
        ]);

        $response->assertOk()
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

        // Assert user created and pre-verified
        $this->assertDatabaseHas('users', [
            'email' => 'new.onboard@example.com',
            'name' => 'New Onboard',
            'password_set' => true,
        ]);

        $newUser = User::where('email', 'new.onboard@example.com')->firstOrFail();
        $this->assertNotNull($newUser->email_verified_at);

        // Assert membership attached
        $this->assertDatabaseHas('organization_memberships', [
            'user_id' => $newUser->id,
            'organization_id' => $this->organizationA->id,
            'status' => MembershipStatus::ACTIVE->value,
        ]);

        // Assert role assigned
        setPermissionsTeamId($this->organizationA->id);
        $this->assertTrue($newUser->hasRole(SystemRole::EMPLOYEE->value));
        setPermissionsTeamId(null);

        // Assert invitation marked accepted
        $this->assertDatabaseHas('organization_invitations', [
            'id' => $invite->id,
            'status' => InvitationStatusEnum::ACCEPTED->value,
        ]);

        Event::assertDispatched(InvitationAccepted::class);
    }

    public function test_accept_invitation_existing_user_logged_in(): void
    {
        Event::fake([InvitationAccepted::class]);

        $existingUser = User::factory()->create([
            'email' => 'existing@example.com',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $invite = Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'existing@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtokenexisting'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        // Generate user token
        $issueJwtAction = app(IssueJwtAction::class);
        $userToken = $issueJwtAction->issueAccessToken($existingUser, null, \App\Enums\Guard::PLATFORM);

        $response = $this->withHeader('Authorization', "Bearer {$userToken}")
            ->postJson('/api/v1/invitations/accept', [
                'token' => 'rawtokenexisting',
            ]);

        $response->assertOk()
            ->assertJsonPath('data.status', 'accepted');

        // Assert membership attached
        $this->assertDatabaseHas('organization_memberships', [
            'user_id' => $existingUser->id,
            'organization_id' => $this->organizationA->id,
            'status' => MembershipStatus::ACTIVE->value,
        ]);

        // Assert role assigned
        setPermissionsTeamId($this->organizationA->id);
        $this->assertTrue($existingUser->hasRole(SystemRole::EMPLOYEE->value));
        setPermissionsTeamId(null);

        // Assert invitation accepted
        $this->assertDatabaseHas('organization_invitations', [
            'id' => $invite->id,
            'status' => InvitationStatusEnum::ACCEPTED->value,
        ]);

        Event::assertDispatched(InvitationAccepted::class);
    }

    public function test_accept_invitation_existing_user_not_logged_in(): void
    {
        // User exists but request is unauthenticated
        User::factory()->create([
            'email' => 'existing2@example.com',
        ]);

        Invitation::create([
            'organization_id' => $this->organizationA->id,
            'email' => 'existing2@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtokenexisting2'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->postJson('/api/v1/invitations/accept', [
            'token' => 'rawtokenexisting2',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'AUTHENTICATION_REQUIRED');
    }

    public function test_security_cross_organization_isolation(): void
    {
        $inviteB = Invitation::create([
            'organization_id' => $this->organizationB->id,
            'email' => 'isolated@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminB->id,
            'token' => hash('sha256', 'tokenb'),
            'status' => InvitationStatusEnum::PENDING,
            'expires_at' => now()->addDays(7),
        ]);

        // Admin A (of organization A) tries to view organization B invite
        $responseShow = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->getJson("/api/v1/organization/invitations/{$inviteB->uuid}");

        $responseShow->assertStatus(404);

        // Admin A tries to revoke organization B invite
        $responseRevoke = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson("/api/v1/organization/invitations/{$inviteB->uuid}/revoke");

        $responseRevoke->assertStatus(404);

        // Admin A tries to resend organization B invite
        $responseResend = $this->withHeaders($this->headers($this->tokenA, $this->organizationA))
            ->postJson("/api/v1/organization/invitations/{$inviteB->uuid}/resend");

        $responseResend->assertStatus(404);
    }
}
