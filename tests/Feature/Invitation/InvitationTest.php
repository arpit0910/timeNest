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
use App\Models\Corporation\Corporation;
use App\Models\Invitation\Invitation;
use App\Models\Membership\CorpMembership;
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

    private Corporation $corpA;
    private Corporation $corpB;
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
        $this->adminRole = Role::where('name', SystemRole::CorpAdmin->value)->firstOrFail();
        $this->employeeRole = Role::where('name', SystemRole::Employee->value)->firstOrFail();

        // 3. Create Corporations
        $this->corpA = Corporation::create([
            'legal_name' => 'Corp A Inc',
            'slug' => 'corp-a',
            'is_active' => true,
            'is_verified' => true,
        ]);

        $this->corpB = Corporation::create([
            'legal_name' => 'Corp B Inc',
            'slug' => 'corp-b',
            'is_active' => true,
            'is_verified' => true,
        ]);

        // 4. Create Corp Admins
        $this->adminA = User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);
        $this->adminB = User::factory()->create(['email_verified_at' => now(), 'is_active' => true]);

        // 5. Attach Admin A to Corp A
        CorpMembership::create([
            'user_id' => $this->adminA->id,
            'corporation_id' => $this->corpA->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);
        setPermissionsTeamId($this->corpA->id);
        $this->adminA->assignRole($this->adminRole);

        // 6. Attach Admin B to Corp B
        CorpMembership::create([
            'user_id' => $this->adminB->id,
            'corporation_id' => $this->corpB->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);
        setPermissionsTeamId($this->corpB->id);
        $this->adminB->assignRole($this->adminRole);

        setPermissionsTeamId(null);

        // 7. Issue Auth Tokens
        $issueJwtAction = app(IssueJwtAction::class);
        $this->tokenA = $issueJwtAction->issueAccessToken($this->adminA, $this->corpA, \App\Enums\Guard::Corp, SystemRole::CorpAdmin->value);
        $this->tokenB = $issueJwtAction->issueAccessToken($this->adminB, $this->corpB, \App\Enums\Guard::Corp, SystemRole::CorpAdmin->value);
    }

    private function headers(string $token, Corporation $corp): array
    {
        return [
            'Authorization' => "Bearer {$token}",
            'X-Corporation-Uuid' => $corp->uuid,
        ];
    }

    public function test_corp_admin_can_create_invitation(): void
    {
        Mail::fake();
        Event::fake([InvitationCreated::class]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson('/api/v1/corp/invitations', [
                'email' => 'new.employee@example.com',
                'role_uuid' => $this->employeeRole->uuid,
            ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => ['uuid', 'email', 'status', 'status_label', 'role']
            ]);

        $this->assertDatabaseHas('corporation_invitations', [
            'corporation_id' => $this->corpA->id,
            'email' => 'new.employee@example.com',
            'role_id' => $this->employeeRole->id,
            'status' => InvitationStatusEnum::Pending->value,
        ]);

        Event::assertDispatched(InvitationCreated::class);
    }

    public function test_cannot_create_invitation_for_invalid_role(): void
    {
        // Try creating with a platform-only role (e.g. AppOwner)
        $platformRole = Role::where('name', SystemRole::AppOwner->value)->firstOrFail();

        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson('/api/v1/corp/invitations', [
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
            'corporation_id' => $this->corpA->id,
            'email' => 'duplicate@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token123'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        // Attempt duplicate
        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson('/api/v1/corp/invitations', [
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
            'corporation_id' => $this->corpA->id,
            'email' => 'pending@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_pending'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        // Create revoked invite
        Invitation::create([
            'corporation_id' => $this->corpA->id,
            'email' => 'revoked@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_revoked'),
            'status' => InvitationStatusEnum::Revoked,
            'expires_at' => now()->addDays(7),
        ]);

        // List all
        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->getJson('/api/v1/corp/invitations');

        $response->assertOk()
            ->assertJsonCount(2, 'data.data');

        // Filter by status (Revoked = 4)
        $responseFiltered = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->getJson('/api/v1/corp/invitations?status=4');

        $responseFiltered->assertOk()
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.email', 'revoked@example.com');
    }

    public function test_show_invitation(): void
    {
        $invite = Invitation::create([
            'corporation_id' => $this->corpA->id,
            'email' => 'show@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_show'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->getJson("/api/v1/corp/invitations/{$invite->uuid}");

        $response->assertOk()
            ->assertJsonPath('data.email', 'show@example.com');
    }

    public function test_revoke_invitation(): void
    {
        Event::fake([InvitationRevoked::class]);

        $invite = Invitation::create([
            'corporation_id' => $this->corpA->id,
            'email' => 'revoke.me@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_revoke'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson("/api/v1/corp/invitations/{$invite->uuid}/revoke");

        $response->assertOk()
            ->assertJsonPath('data.status', InvitationStatusEnum::Revoked->value);

        $this->assertDatabaseHas('corporation_invitations', [
            'id' => $invite->id,
            'status' => InvitationStatusEnum::Revoked->value,
            'revoked_by' => $this->adminA->id,
        ]);

        Event::assertDispatched(InvitationRevoked::class);
    }

    public function test_resend_invitation(): void
    {
        Event::fake([InvitationCreated::class]);

        $invite = Invitation::create([
            'corporation_id' => $this->corpA->id,
            'email' => 'resend.me@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'token_old'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
            'resend_count' => 0,
        ]);

        $response = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson("/api/v1/corp/invitations/{$invite->uuid}/resend");

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
            'corporation_id' => $this->corpA->id,
            'email' => 'validate@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtoken123'),
            'status' => InvitationStatusEnum::Pending,
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
            'corporation_id' => $this->corpA->id,
            'email' => 'new.onboard@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtoken123'),
            'status' => InvitationStatusEnum::Pending,
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
        $this->assertDatabaseHas('corp_memberships', [
            'user_id' => $newUser->id,
            'corporation_id' => $this->corpA->id,
            'status' => MembershipStatus::Active->value,
        ]);

        // Assert role assigned
        setPermissionsTeamId($this->corpA->id);
        $this->assertTrue($newUser->hasRole(SystemRole::Employee->value));
        setPermissionsTeamId(null);

        // Assert invitation marked accepted
        $this->assertDatabaseHas('corporation_invitations', [
            'id' => $invite->id,
            'status' => InvitationStatusEnum::Accepted->value,
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
            'corporation_id' => $this->corpA->id,
            'email' => 'existing@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtokenexisting'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        // Generate user token
        $issueJwtAction = app(IssueJwtAction::class);
        $userToken = $issueJwtAction->issueAccessToken($existingUser, null, \App\Enums\Guard::Platform);

        $response = $this->withHeader('Authorization', "Bearer {$userToken}")
            ->postJson('/api/v1/invitations/accept', [
                'token' => 'rawtokenexisting',
            ]);

        $response->assertOk()
            ->assertJsonPath('data.status', 'accepted');

        // Assert membership attached
        $this->assertDatabaseHas('corp_memberships', [
            'user_id' => $existingUser->id,
            'corporation_id' => $this->corpA->id,
            'status' => MembershipStatus::Active->value,
        ]);

        // Assert role assigned
        setPermissionsTeamId($this->corpA->id);
        $this->assertTrue($existingUser->hasRole(SystemRole::Employee->value));
        setPermissionsTeamId(null);

        // Assert invitation accepted
        $this->assertDatabaseHas('corporation_invitations', [
            'id' => $invite->id,
            'status' => InvitationStatusEnum::Accepted->value,
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
            'corporation_id' => $this->corpA->id,
            'email' => 'existing2@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminA->id,
            'token' => hash('sha256', 'rawtokenexisting2'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->postJson('/api/v1/invitations/accept', [
            'token' => 'rawtokenexisting2',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('error_code', 'AUTHENTICATION_REQUIRED');
    }

    public function test_security_cross_corporation_isolation(): void
    {
        $inviteB = Invitation::create([
            'corporation_id' => $this->corpB->id,
            'email' => 'isolated@example.com',
            'role_id' => $this->employeeRole->id,
            'invited_by_user_id' => $this->adminB->id,
            'token' => hash('sha256', 'tokenb'),
            'status' => InvitationStatusEnum::Pending,
            'expires_at' => now()->addDays(7),
        ]);

        // Admin A (of Corp A) tries to view Corp B invite
        $responseShow = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->getJson("/api/v1/corp/invitations/{$inviteB->uuid}");

        $responseShow->assertStatus(404);

        // Admin A tries to revoke Corp B invite
        $responseRevoke = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson("/api/v1/corp/invitations/{$inviteB->uuid}/revoke");

        $responseRevoke->assertStatus(404);

        // Admin A tries to resend Corp B invite
        $responseResend = $this->withHeaders($this->headers($this->tokenA, $this->corpA))
            ->postJson("/api/v1/corp/invitations/{$inviteB->uuid}/resend");

        $responseResend->assertStatus(404);
    }
}
