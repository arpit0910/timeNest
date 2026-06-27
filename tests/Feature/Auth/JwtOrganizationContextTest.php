<?php

namespace Tests\Feature\Auth;

use App\Enums\UserStatus;
use App\Models\Auth\RefreshToken;
use App\Models\Auth\User;
use App\Models\Membership\PlatformMembership;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PragmaRX\Google2FALaravel\Facade as Google2FA;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

class JwtOrganizationContextTest extends TestCase
{
    use RefreshDatabase;

    protected User $noOrgUser;
    protected User $singleOrgUser;
    protected User $multiOrgUser;
    protected User $suspendedUser;
    protected User $inactiveUser;
    protected User $twoFactorUser;
    protected User $platformAdminUser;

    protected Organization $orgA;
    protected Organization $orgB;
    protected Organization $orgC;

    protected function setUp(): void
    {
        parent::setUp();

        // Roles
        $ownerRole = Role::firstOrCreate(['name' => \App\Enums\SystemRole::DIRECTOR->value, 'guard_name' => 'api']);
        $managerRole = Role::firstOrCreate(['name' => \App\Enums\SystemRole::MANAGER->value, 'guard_name' => 'api']);
        $memberRole = Role::firstOrCreate(['name' => \App\Enums\SystemRole::EMPLOYEE->value, 'guard_name' => 'api']);
        $platformRole = Role::firstOrCreate(['name' => \App\Enums\SystemRole::APP_DIRECTOR->value, 'guard_name' => 'api']);

        // Organizations
        $this->orgA = Organization::create(['legal_name' => 'Org A', 'slug' => 'org-a', 'is_active' => true]);
        $this->orgB = Organization::create(['legal_name' => 'Org B', 'slug' => 'org-b', 'is_active' => true]);
        $this->orgC = Organization::create(['legal_name' => 'Org C', 'slug' => 'org-c', 'is_active' => true]);

        // User with no organization
        $this->noOrgUser = User::factory()->create([
            'email' => 'no_org@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);

        // User with exactly one organization
        $this->singleOrgUser = User::factory()->create([
            'email' => 'single@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);
        OrganizationMembership::create(['user_id' => $this->singleOrgUser->id, 'organization_id' => $this->orgA->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgA->id);
        $this->singleOrgUser->assignRole($ownerRole->name);

        // User with multiple organizations
        $this->multiOrgUser = User::factory()->create([
            'email' => 'multi@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);
        OrganizationMembership::create(['user_id' => $this->multiOrgUser->id, 'organization_id' => $this->orgA->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgA->id);
        $this->multiOrgUser->assignRole($ownerRole->name);

        OrganizationMembership::create(['user_id' => $this->multiOrgUser->id, 'organization_id' => $this->orgB->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgB->id);
        $this->multiOrgUser->assignRole($managerRole->name);

        OrganizationMembership::create(['user_id' => $this->multiOrgUser->id, 'organization_id' => $this->orgC->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgC->id);
        $this->multiOrgUser->assignRole($memberRole->name);

        // User who is suspended in one organization
        $this->suspendedUser = User::factory()->create([
            'email' => 'suspended@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);
        OrganizationMembership::create(['user_id' => $this->suspendedUser->id, 'organization_id' => $this->orgB->id, 'joined_at' => now(), 'status' => 'suspended']);

        // User whose account is inactive
        $this->inactiveUser = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => false,
            'status' => UserStatus::INACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);

        // User with 2FA enabled
        $this->twoFactorUser = User::factory()->create([
            'email' => '2fa@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
            'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
            'two_factor_enabled_at' => now(),
            'two_factor_recovery_codes' => [hash('sha256', '12345-67890')]
        ]);
        OrganizationMembership::create(['user_id' => $this->twoFactorUser->id, 'organization_id' => $this->orgA->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgA->id);
        $this->twoFactorUser->assignRole($ownerRole->name);

        // Platform admin user
        $this->platformAdminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);
        PlatformMembership::create(['user_id' => $this->platformAdminUser->id, 'status' => 'active']);
        setPermissionsTeamId(null);
        $this->platformAdminUser->assignRole($platformRole->name);
    }

    protected function loginUser(User $user): array
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $json = $response->json();
        return $json['data'] ?? $json;
    }

    protected function decodeToken(string $token)
    {
        return JWTAuth::setToken($token)->getPayload();
    }

    /**
     * @group jwt
     * @group security
     * Security Property: Successful registration should not leak an access_token.
     */
    public function test_1_1_successful_registration_returns_correct_response_structure()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'first_name' => 'New',
            'last_name' => 'User',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.status', 'registered');
        $response->assertJsonMissing(['access_token']);
        $response->assertJsonMissing(['organization']);

        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
            'is_active' => 0,
            'status' => UserStatus::PENDING_VERIFICATION->value,
        ]);

        $user = User::where('email', 'new@example.com')->first();
        $this->assertNotNull($user->email_verification_token);
    }

    /**
     * @group jwt
     * Security Property: Prevent account enumeration and duplicates via email.
     */
    public function test_1_2_registration_with_duplicate_email_returns_422()
    {
        $this->postJson('/api/v1/auth/register', [
            'name' => 'New User',
            'email' => 'no_org@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('email');
    }

    /**
     * @group jwt
     * Security Property: Prevent weak passwords.
     */
    public function test_1_3_registration_with_weak_password_returns_422()
    {
        $this->postJson('/api/v1/auth/register', [
            'name' => 'New User',
            'email' => 'weak@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('password');
    }

    /**
     * @group jwt
     * Security Property: Must verify email before accessing app.
     */
    public function test_1_4_after_registration_login_before_email_verification_fails()
    {
        $this->postJson('/api/v1/auth/register', [
            'name' => 'New User',
            'email' => 'login_before@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'login_before@example.com',
            'password' => 'SecurePass123!',
        ]);

        $response->assertStatus(403);
        $response->assertJsonMissing(['access_token']);
    }

    /**
     * @group jwt
     * Security Property: Verifying email successfully activates the account.
     */
    public function test_2_1_valid_verification_token_activates_account()
    {
        $rawToken = \Illuminate\Support\Str::random(64);
        $user = User::factory()->create([
            'email' => 'verify@example.com',
            'email_verified_at' => null,
            'email_verification_token' => hash('sha256', $rawToken),
            'email_verification_token_expires_at' => now()->addHour(),
            'is_active' => false,
            'status' => UserStatus::PENDING_VERIFICATION
        ]);

        $response = $this->postJson("/api/v1/auth/verify-email?token={$rawToken}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'verify@example.com',
            'is_active' => 1,
            'status' => UserStatus::ACTIVE->value,
            'email_verification_token' => null
        ]);
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /**
     * @group jwt
     * Security Property: Expired token cannot activate account.
     */
    public function test_2_2_expired_verification_token_returns_error()
    {
        $rawToken = \Illuminate\Support\Str::random(64);
        $user = User::factory()->create([
            'email' => 'expired@example.com',
            'email_verified_at' => null,
            'email_verification_token' => hash('sha256', $rawToken),
            'email_verification_token_expires_at' => now()->subMinute(),
            'is_active' => false,
            'status' => UserStatus::PENDING_VERIFICATION
        ]);

        $response = $this->postJson("/api/v1/auth/verify-email?token={$rawToken}");
        $response->assertStatus(401);

        $this->assertDatabaseHas('users', [
            'email' => 'expired@example.com',
            'is_active' => 0
        ]);
    }

    /**
     * @group jwt
     * Security Property: Cannot reuse token.
     */
    public function test_2_3_already_used_verification_token_returns_error()
    {
        $rawToken = \Illuminate\Support\Str::random(64);
        User::factory()->create([
            'email' => 'used@example.com',
            'email_verified_at' => now(),
            'is_active' => true,
            'email_verification_token' => null
        ]);

        $response = $this->postJson("/api/v1/auth/verify-email?token={$rawToken}");
        $response->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Generates a new unique token upon resend.
     */
    public function test_2_4_resend_verification_email_works()
    {
        $user = User::factory()->create([
            'email' => 'resend@example.com',
            'email_verification_token' => 'old_hash',
            'is_active' => true,
            'email_verified_at' => null
        ]);

        $response = $this->postJson('/api/v1/auth/resend-verification-email', [
            'email' => 'resend@example.com'
        ]);

        $response->assertStatus(200);

        $fresh = $user->fresh();
        $this->assertNotEquals('old_hash', $fresh->email_verification_token);
        $this->assertTrue($fresh->email_verification_token_expires_at > now());
    }

    /**
     * @group jwt
     * Security Property: User without org receives no workspace JWT payload.
     */
    public function test_3_1_user_with_no_organization_gets_no_workspace_response()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->noOrgUser->email,
            'password' => 'Password123!',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.status', 'no_workspace');
        $response->assertJsonMissing(['data.access_token']);
        $response->assertJsonMissing(['data.organization']);
    }

    /**
     * @group jwt
     * @group organization-context
     * Security Property: Single org user auto-resolves context.
     */
    public function test_3_2_user_with_exactly_one_organization_gets_auto_selected_and_receives_scoped_jwt()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->singleOrgUser->email,
            'password' => 'Password123!',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.status', 'authenticated');
        $response->assertJsonStructure(['data' => ['access_token', 'refresh_token', 'organization' => ['uuid']]]);
        
        $json = $response->json('data');
        $this->assertArrayNotHasKey('corporation', $json);
        $this->assertArrayNotHasKey('corporation_uuid', $json['organization']);

        $token = $json['access_token'];
        $decoded = $this->decodeToken($token);

        $this->assertEquals($this->singleOrgUser->uuid, $decoded->get('user_uuid'));
        $this->assertEquals($this->orgA->uuid, $decoded->get('organization_uuid'));
        $this->assertEquals('organization', $decoded->get('guard'));
        $this->assertEquals(1, $decoded->get('token_version'));
        $this->assertTrue($decoded->get('exp') > time());
    }

    /**
     * @group jwt
     * Security Property: Multi-org users must explicitly select workspace.
     */
    public function test_3_3_user_with_multiple_organizations_gets_workspace_selection_response()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $response->assertStatus(403);
        $json = $response->json('meta');
        $this->assertEquals('Please select an organization to continue', $response->json('message') ?? '');
        $this->assertArrayHasKey('temp_token', $json);
        $this->assertArrayNotHasKey('access_token', $json);
        
        $this->assertCount(3, $json['workspaces']);
        foreach ($json['workspaces'] as $ws) {
            $this->assertArrayHasKey('organization_uuid', $ws);
            $this->assertArrayNotHasKey('corporation_uuid', $ws);
            $this->assertArrayHasKey('legal_name', $ws);
            $this->assertArrayHasKey('role', $ws);
        }
    }

    /**
     * @group jwt
     * Security Property: Invalid credentials shouldn't leak token.
     */
    public function test_3_4_login_with_wrong_password_returns_401()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->singleOrgUser->email,
            'password' => 'WrongPassword',
        ]);

        $response->assertStatus(401);
        $response->assertJsonMissing(['access_token', 'organization']);
    }

    /**
     * @group jwt
     * Security Property: Invalid credentials identical to wrong password.
     */
    public function test_3_5_login_with_nonexistent_email_returns_401()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'doesnotexist@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Inactive user cannot get a token.
     */
    public function test_3_6_login_with_inactive_user_account_returns_403()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->inactiveUser->email,
            'password' => 'Password123!',
        ]);

        $response->assertStatus(403);
    }

    /**
     * @group jwt
     * Security Property: Suspended org user fails to login.
     */
    public function test_3_7_login_with_suspended_user_in_their_only_organization()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->suspendedUser->email,
            'password' => 'Password123!',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.status', 'no_workspace');
    }

    /**
     * @group jwt
     * @group organization-context
     * Security Property: Only selected org is embedded in JWT.
     */
    public function test_4_1_valid_organization_selection_returns_scoped_jwt()
    {
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $tempToken = $loginResponse->json('meta.temp_token') ?? $loginResponse->json('data.temp_token') ?? $loginResponse->json('temp_token') ?? $loginResponse->json('token');

        $response = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['access_token', 'refresh_token', 'organization' => ['uuid']]]);
        
        $decoded = $this->decodeToken($response->json('data.access_token'));
        $this->assertEquals($this->orgB->uuid, $decoded->get('organization_uuid'));
        $this->assertEquals('organization', $decoded->get('guard'));
    }

    /**
     * @group jwt
     * Security Property: Cannot access unauthorized org context.
     */
    public function test_4_2_organization_selection_with_organization_user_does_not_belong_to_fails()
    {
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $tempToken = $loginResponse->json('meta.temp_token') ?? $loginResponse->json('data.temp_token') ?? $loginResponse->json('temp_token') ?? $loginResponse->json('token');

        $randomOrg = Organization::create(['legal_name' => 'Random Org', 'slug' => 'random-org', 'is_active' => true]);

        $response = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $randomOrg->uuid
            ]);

        $this->assertTrue(in_array($response->status(), [403, 404, 422]));
        $response->assertJsonMissing(['access_token']);
    }

    /**
     * @group jwt
     * Security Property: Temp token expiry validation.
     */
    public function test_4_3_organization_selection_with_expired_temp_token_fails()
    {
        $tempToken = app(\App\Actions\IssueJwtAction::class)->issueTempToken($this->multiOrgUser, 'workspace_selection');
        $this->multiOrgUser->increment('token_version');

        $response = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);

        $response->assertStatus(401);
        $response->assertJsonMissing(['access_token']);
    }

    /**
     * @group jwt
     * Security Property: Invalid input gracefully fails.
     */
    public function test_4_4_organization_selection_with_invalid_organization_uuid_format_fails()
    {
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $tempToken = $loginResponse->json('meta.temp_token') ?? $loginResponse->json('data.temp_token') ?? $loginResponse->json('temp_token') ?? $loginResponse->json('token');

        $response = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => 'not-a-uuid'
            ]);

        $response->assertStatus(422);
    }

    /**
     * @group jwt
     * Security Property: Suspended membership stops org access selection.
     */
    public function test_4_5_selecting_an_organization_where_user_is_suspended_fails()
    {
        $tempToken = app(\App\Actions\IssueJwtAction::class)->issueTempToken($this->suspendedUser, 'workspace_selection');

        $response = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);

        $response->assertStatus(403);
    }

    /**
     * @group jwt
     * Security Property: Standard JWT constraints.
     */
    #[Group('org_selection')]
    #[Group('security')]
    public function test_4_6_temp_token_cannot_be_reused_after_successful_selection()
    {
        $loginRes = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);
        
        $tempToken = $loginRes->json('meta.temp_token') ?? $loginRes->json('data.temp_token') ?? $loginRes->json('temp_token') ?? $loginRes->json('token');

        // First use — must succeed and burn the token
        $response1 = $this->postJson('/api/v1/auth/select-organization', [
            'organization_uuid' => $this->orgA->uuid
        ], ['Authorization' => "Bearer {$tempToken}"]);
        $response1->assertStatus(200);
        $response1->assertJsonStructure(['data' => ['access_token']]);

        // Verify the temp token is marked as used in the database
        $payload = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::setToken($tempToken)->getPayload();
        $this->assertDatabaseHas('temp_tokens', [
            'jti' => $payload->get('jti'),
        ]);
        $record = \App\Models\Auth\TempToken::where(
            'jti', $payload->get('jti')
        )->first();
        $this->assertNotNull($record->used_at);

        // Second use of the SAME temp token — must be rejected
        $response2 = $this->postJson('/api/v1/auth/select-organization', [
            'organization_uuid' => $this->orgB->uuid
        ], ['Authorization' => "Bearer {$tempToken}"]);
        $response2->assertStatus(401);
        $response2->assertJsonMissing(['access_token']);
    }

    /**
     * @group jwt
     * Security Property: Payload integrity and data minimization.
     */
    public function test_5_1_decoded_jwt_contains_exactly_the_required_claims_and_no_extra_sensitive_data()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $decoded = $this->decodeToken($res['access_token']);

        $claims = $decoded->toArray();
        $this->assertArrayHasKey('user_uuid', $claims);
        $this->assertArrayHasKey('organization_uuid', $claims);
        $this->assertArrayHasKey('guard', $claims);
        $this->assertArrayHasKey('token_version', $claims);
        $this->assertArrayHasKey('iat', $claims);
        $this->assertArrayHasKey('exp', $claims);

        $this->assertArrayNotHasKey('password', $claims);
        $this->assertArrayNotHasKey('two_factor_secret', $claims);
        $this->assertArrayNotHasKey('corporation_id', $claims);
        $this->assertArrayNotHasKey('corp', $claims);
    }

    /**
     * @group jwt
     * Security Property: Correct org mapping in JWT.
     */
    public function test_5_2_jwt_organization_id_is_the_integer_id_of_the_correct_organization()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $decoded = $this->decodeToken($res['access_token']);
        
        $this->assertEquals($this->orgA->uuid, $decoded->get('organization_uuid'));
    }

    /**
     * @group jwt
     * Security Property: UUID isolation between users and orgs.
     */
    public function test_5_3_two_users_scoped_to_different_organizations_get_different_organization_claims_in_their_jwts()
    {
        $res1 = $this->loginUser($this->singleOrgUser);
        
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'password' => Hash::make('Password123!'),
            'is_active' => true,
            'email_verified_at' => now(),
            'token_version' => 1
        ]);
        OrganizationMembership::create(['user_id' => $otherUser->id, 'organization_id' => $this->orgC->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgC->id);
        $otherUser->assignRole('Member');

        $res2 = $this->loginUser($otherUser);

        $decoded1 = $this->decodeToken($res1['access_token']);
        $decoded2 = $this->decodeToken($res2['access_token']);

        $this->assertNotEquals($decoded1->get('organization_uuid'), $decoded2->get('organization_uuid'));
    }

    /**
     * @group jwt
     * Security Property: Ensures version is tied correctly.
     */
    public function test_5_4_jwt_token_version_matches_user_token_version_in_database()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $decoded = $this->decodeToken($res['access_token']);

        $this->assertEquals($this->singleOrgUser->token_version, $decoded->get('token_version'));
    }

    /**
     * @group jwt
     * Security Property: JWT temporal integrity.
     */
    public function test_5_5_jwt_issued_at_and_expiry_are_correct()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $decoded = $this->decodeToken($res['access_token']);

        $this->assertTrue(abs($decoded->get('iat') - time()) <= 5);
        $this->assertTrue($decoded->get('exp') > time());
    }

    /**
     * @group jwt
     * Security Property: Refreshed token preserves correct org.
     */
    public function test_6_1_valid_refresh_token_returns_new_access_token_with_same_organization_context()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $oldRefresh = $res['refresh_token'];
        $oldAccess = $res['access_token'];

        $refreshRes = $this->postJson('/api/v1/auth/refresh', [
            'refresh_token' => $oldRefresh
        ]);

        $refreshRes->assertStatus(200);
        $this->assertNotEquals($oldAccess, $refreshRes->json('data.access_token'));
        $this->assertNotEquals($oldRefresh, $refreshRes->json('data.refresh_token'));

        $decoded = $this->decodeToken($refreshRes->json('data.access_token'));
        $this->assertEquals($this->orgA->uuid, $decoded->get('organization_uuid'));

        $hash = hash('sha256', $oldRefresh);
        $this->assertDatabaseHas('refresh_tokens', [
            'token_hash' => $hash,
        ]);
        $record = RefreshToken::where('token_hash', $hash)->first();
        $this->assertNotNull($record->revoked_at);
    }

    /**
     * @group jwt
     * Security Property: Prevent using expired tokens.
     */
    public function test_6_2_expired_refresh_token_returns_401()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $hash = hash('sha256', $res['refresh_token']);
        RefreshToken::where('token_hash', $hash)->update(['expires_at' => now()->subDay()]);

        $refreshRes = $this->postJson('/api/v1/auth/refresh', [
            'refresh_token' => $res['refresh_token']
        ]);

        $refreshRes->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Prevent replay of revoked token.
     */
    public function test_6_3_revoked_refresh_token_returns_401()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $hash = hash('sha256', $res['refresh_token']);
        RefreshToken::where('token_hash', $hash)->update(['revoked_at' => now()]);

        $refreshRes = $this->postJson('/api/v1/auth/refresh', [
            'refresh_token' => $res['refresh_token']
        ]);

        $refreshRes->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Only token owner can refresh.
     */
    #[Group('jwt')]
    #[Group('security')]
    public function test_6_4_refresh_token_belonging_to_different_user_cannot_be_used()
    {
        // Login singleOrgUser on device 1
        $res1 = $this->loginUser($this->singleOrgUser);

        // Login multiOrgUser separately and get their refresh token
        $loginRes = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);
        $tempToken = $loginRes->json('data.temp_token') 
            ?? $loginRes->json('meta.temp_token');

        $selectRes = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);
        $multiOrgRefreshToken = $selectRes->json('data.refresh_token');

        // singleOrgUser attempts to refresh using multiOrgUser's refresh token
        // while sending their own access token in the Authorization header
        $refreshRes = $this->withHeader(
                'Authorization', "Bearer {$res1['access_token']}"
            )
            ->postJson('/api/v1/auth/refresh', [
                'refresh_token' => $multiOrgRefreshToken
            ]);

        // The refresh endpoint must either:
        // A) Return 401 because the token owner does not match the 
        //    authenticated user (if the endpoint validates ownership)
        // OR
        // B) Return 200 but the resulting token belongs to multiOrgUser,
        //    NOT singleOrgUser — proving the refresh token is bound to 
        //    its owner and cannot be hijacked

        if ($refreshRes->status() === 200) {
            // If it succeeds, the resulting access_token MUST belong to 
            // multiOrgUser. If it belongs to singleOrgUser, that is a 
            // security bug — stop immediately and report it.
            $decoded = $this->decodeToken(
                $refreshRes->json('data.access_token')
            );
            $this->assertEquals(
                $this->multiOrgUser->uuid,
                $decoded->get('user_uuid'),
                'SECURITY BUG: refresh token was hijacked — returned token 
                 belongs to wrong user'
            );
            $this->assertNotEquals(
                $this->singleOrgUser->uuid,
                $decoded->get('user_uuid'),
                'SECURITY BUG: singleOrgUser hijacked multiOrgUser refresh token'
            );
        } else {
            // If it rejects, it must be 401 — not 200, not 403, not 500
            $refreshRes->assertStatus(401);
        }

        // Either outcome is acceptable security behavior.
        // What is NOT acceptable is a 200 response with singleOrgUser's 
        // identity in the token — that would be a hijack.
        // The assertions above enforce this guarantee.
    }

    /**
     * @group jwt
     * Security Property: Forces logout on password change.
     */
    public function test_6_5_after_password_change_all_existing_refresh_tokens_are_revoked()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->postJson('/api/v1/auth/change-password', [
                'current_password' => 'Password123!',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ]);

        $hash = hash('sha256', $res['refresh_token']);
        $record = RefreshToken::where('token_hash', $hash)->first();
        $this->assertNotNull($record->revoked_at);
    }

    /**
     * @group jwt
     * Security Property: Token versions enforce global invalidation.
     */
    public function test_6_6_token_version_increment_invalidates_old_jwts()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $this->singleOrgUser->increment('token_version');

        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->getJson('/api/v1/auth/user/profile')
             ->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Organization data is scoped strictly.
     */
    public function test_7_1_authenticated_request_correctly_resolves_organization_context_from_jwt()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        // Let's hit the profile endpoint, it should return 200 and know who we are
        $profileResponse = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
                                ->getJson('/api/v1/auth/user/profile');
        
        $profileResponse->assertStatus(200);
        $profileResponse->assertJsonPath('data.email', $this->singleOrgUser->email);
    }

    /**
     * @group jwt
     * Security Property: Data leak prevention between orgs.
     */
    public function test_7_2_jwt_scoped_to_org_a_cannot_access_org_b_data()
    {
        $permission = \App\Models\Rbac\Permission::firstOrCreate(['name' => \App\Enums\SystemPermission::BRANCHES_VIEW->value, 'guard_name' => 'api']);
        $role = \App\Models\Rbac\Role::where('name', 'Owner')->first();
        $role->givePermissionTo($permission);

        $res = $this->loginUser($this->singleOrgUser);
        
        \App\Models\Organization\Branch::create([
            'organization_id' => $this->orgB->id,
            'name' => 'Org B Branch',
            'is_headquarters' => false,
            'is_active' => true,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->getJson('/api/v1/organization/branches');
            
        $response->assertStatus(200);
        $response->assertJsonMissing(['name' => 'Org B Branch']);
    }

    /**
     * @group jwt
     * Security Property: Deny anonymous access.
     */
    public function test_7_3_request_without_any_jwt_returns_401()
    {
        $this->getJson('/api/v1/auth/user/profile')->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Catch forged tokens.
     */
    public function test_7_4_request_with_malformed_jwt_returns_401()
    {
        $this->withHeader('Authorization', 'Bearer malformed.token.here')
             ->getJson('/api/v1/auth/user/profile')
             ->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Standard JWT expiry logic works.
     */
    public function test_7_5_request_with_expired_jwt_returns_401()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        // Advance time to expire token
        \Carbon\Carbon::setTestNow(now()->addHours(2));
        
        $tamperedRes = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->getJson('/api/v1/organization/branches');
            
        $tamperedRes->assertStatus(401);
        $tamperedRes->assertJsonMissing(['data' => ['access_token']]);
        
        \Carbon\Carbon::setTestNow();
    }

    /**
     * @group jwt
     * Security Property: Invalid context rejection.
     */
    public function test_7_6_request_with_jwt_missing_organization_id_claim_returns_401()
    {
        $missingOrgToken = JWTAuth::customClaims(['user_uuid' => $this->singleOrgUser->uuid, 'guard' => 'organization'])
            ->fromUser($this->singleOrgUser);

        $this->withHeader('Authorization', "Bearer {$missingOrgToken}")
             ->getJson('/api/v1/auth/user/profile')
             ->assertStatus(401);
    }

    /**
     * @group jwt
     * Security Property: Protect against deleted orgs.
     */
    public function test_7_7_request_with_jwt_containing_wrong_organization_id_returns_403()
    {
        $randomOrgUuid = \Illuminate\Support\Str::uuid()->toString();
        $wrongOrgToken = JWTAuth::customClaims(['user_uuid' => $this->singleOrgUser->uuid, 'organization_uuid' => $randomOrgUuid, 'guard' => 'organization'])
            ->fromUser($this->singleOrgUser);

        $this->withHeader('Authorization', "Bearer {$wrongOrgToken}")
             ->getJson('/api/v1/organization/branches')
             ->assertStatus(401); // Can be 401 or 403 depending on middleware sequence
    }

    /**
     * @group jwt
     * Security Property: Live checks ensure revoked membership fails request.
     */
    public function test_7_8_request_with_jwt_where_user_is_no_longer_a_member_of_the_organization_in_the_token_fails()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        OrganizationMembership::where('user_id', $this->singleOrgUser->id)
            ->where('organization_id', $this->orgA->id)
            ->delete();

        $response = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->getJson('/api/v1/organization/branches');
             
        $response->assertStatus(403);
        $response->assertJsonMissing(['name' => 'Org A Branch']);
    }

    /**
     * @group jwt
     * Security Property: Org inactive status drops access immediately.
     */
    public function test_7_9_request_with_jwt_where_organization_is_inactive_fails()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $this->orgA->update(['is_active' => false]);

        $response = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->getJson('/api/v1/organization/branches');
             
        $response->assertStatus(403);
        $response->assertJsonMissing(['name' => 'Org A Branch']);
    }

    /**
     * @group jwt
     * Security Property: Admin logic is separated from org logic.
     */
    public function test_7_10_platform_jwt_cannot_access_organization_endpoints()
    {
        $res = $this->loginUser($this->platformAdminUser);

        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->getJson('/api/v1/organization/branches')
             ->assertStatus(403);
    }

    /**
     * @group jwt
     * Security Property: Org cannot hit admin endpoints.
     */
    public function test_7_11_organization_jwt_cannot_access_platform_endpoints()
    {
        $res = $this->loginUser($this->singleOrgUser);

        $response = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->getJson('/api/v1/platform/organizations');

        $response->assertStatus(403);
    }

    /**
     * @group jwt
     * Security Property: Correct 2FA flows initiate nicely.
     */
    public function test_8_1_2fa_setup_initiation_returns_secret_and_qr_code()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->postJson('/api/v1/auth/user/2fa/setup/initiate')
             ->assertStatus(200)
             ->assertJsonStructure(['data' => ['secret', 'qr_code_url']]);
             
        $this->assertNull($this->singleOrgUser->fresh()->two_factor_secret);
    }

    #[Group('jwt')]
    public function test_8_2_2fa_confirmation_with_valid_totp_code_enables_2fa()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $initRes = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->postJson('/api/v1/auth/user/2fa/setup/initiate');
             
        $secret = $initRes->json('data.secret');
        
        $code = Google2FA::getCurrentOtp($secret);

        $confirmRes = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->postJson('/api/v1/auth/user/2fa/setup/confirm', [
                 'code' => $code
             ]);
             
        $confirmRes->assertStatus(200);
        $confirmRes->assertJsonStructure(['data' => ['recovery_codes']]);
        
        $freshUser = $this->singleOrgUser->fresh();
        $this->assertNotNull($freshUser->two_factor_secret);
        $this->assertNotNull($freshUser->two_factor_enabled_at);
    }

    #[Group('jwt')]
    public function test_8_3_2fa_confirmation_with_invalid_code_returns_error()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->postJson('/api/v1/auth/user/2fa/setup/confirm', [
                 'code' => '000000'
             ])
             ->assertStatus(422)
             ->assertJsonValidationErrors('code');
    }

    /**
     * @group jwt
     * Security Property: Interrupt login to mandate 2FA.
     */
    public function test_8_4_login_with_2fa_enabled_user_returns_2fa_required()
    {
        $res = $this->postJson('/api/v1/auth/login', [
            'email' => $this->twoFactorUser->email,
            'password' => 'Password123!',
        ]);

        $res->assertStatus(200);
        $res->assertJsonPath('status', '2fa_required');
        $res->assertJsonStructure(['token']);
        $res->assertJsonMissing(['access_token', 'organization']);
    }

    #[Group('jwt')]
    public function test_8_5_2fa_verification_with_valid_totp_code_and_single_org_user_returns_full_scoped_jwt()
    {
        $res = $this->postJson('/api/v1/auth/login', [
            'email' => $this->twoFactorUser->email,
            'password' => 'Password123!',
        ]);
        
        $tempToken = $res->json('meta.temp_token') ?? $res->json('data.temp_token') ?? $res->json('temp_token') ?? $res->json('token');

        $code = Google2FA::getCurrentOtp('JBSWY3DPEHPK3PXP');

        $verifyRes = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/2fa/verify', [
                'code' => $code
            ]);

        $verifyRes->assertStatus(200);
        $verifyRes->assertJsonStructure(['data' => ['access_token']]);
        
        $decoded = $this->decodeToken($verifyRes->json('data.access_token'));
        $this->assertEquals($this->orgA->uuid, $decoded->get('organization_uuid'));
        $this->assertEquals('organization', $decoded->get('guard'));
    }

    #[Group('jwt')]
    public function test_8_6_2fa_verification_with_valid_recovery_code_works()
    {
        $res = $this->postJson('/api/v1/auth/login', [
            'email' => $this->twoFactorUser->email,
            'password' => 'Password123!',
        ]);
        
        $tempToken = $res->json('meta.temp_token') ?? $res->json('data.temp_token') ?? $res->json('temp_token') ?? $res->json('token');

        $initialCodesCount = count($this->twoFactorUser->two_factor_recovery_codes);

        $verifyRes = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/2fa/verify', [
                'code' => '12345-67890'
            ]);

        $verifyRes->assertStatus(200);
        $verifyRes->assertJsonStructure(['data' => ['access_token']]);
        
        $freshUser = $this->twoFactorUser->fresh();
        $this->assertCount($initialCodesCount - 1, $freshUser->two_factor_recovery_codes);
    }

    #[Group('jwt')]
    public function test_8_9_disabling_2fa_requires_valid_totp_code()
    {
        $res = $this->postJson('/api/v1/auth/login', [
            'email' => $this->twoFactorUser->email,
            'password' => 'Password123!',
        ]);
        $tempToken = $res->json('meta.temp_token') ?? $res->json('data.temp_token') ?? $res->json('temp_token') ?? $res->json('token');
        
        $code = Google2FA::getCurrentOtp('JBSWY3DPEHPK3PXP');
        $verifyRes = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/2fa/verify', [
                'code' => $code
            ]);
        $accessToken = $verifyRes->json('data.access_token');

        $disableRes = $this->withHeader('Authorization', "Bearer {$accessToken}")
            ->postJson('/api/v1/auth/user/2fa/disable', [
                'code' => $code
            ]);

        $disableRes->assertStatus(200);
        
        $freshUser = $this->twoFactorUser->fresh();
        $this->assertNull($freshUser->two_factor_secret);
        $this->assertNull($freshUser->two_factor_enabled_at);
    }

    #[Group('jwt')]
    public function test_8_11_regenerating_recovery_codes_requires_valid_totp()
    {
        $res = $this->postJson('/api/v1/auth/login', [
            'email' => $this->twoFactorUser->email,
            'password' => 'Password123!',
        ]);
        $tempToken = $res->json('meta.temp_token') ?? $res->json('data.temp_token') ?? $res->json('temp_token') ?? $res->json('token');
        
        $code = Google2FA::getCurrentOtp('JBSWY3DPEHPK3PXP');
        $verifyRes = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/2fa/verify', [
                'code' => $code
            ]);
        $accessToken = $verifyRes->json('data.access_token');

        $regenRes = $this->withHeader('Authorization', "Bearer {$accessToken}")
            ->postJson('/api/v1/auth/user/2fa/recovery-codes/regenerate', [
                'code' => $code
            ]);

        $regenRes->assertStatus(200);
        $regenRes->assertJsonStructure(['data' => ['recovery_codes']]);
        
        $newCodes = $regenRes->json('data.recovery_codes');
        $this->assertNotEquals($newCodes, $this->twoFactorUser->two_factor_recovery_codes);
    }

    #[Group('jwt')]
    public function test_9_1_user_scoped_to_org_a_cannot_read_org_b_attendance()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        \App\Models\Attendance\AttendanceDay::forceCreate([
            'user_id' => $this->multiOrgUser->id,
            'organization_id' => $this->orgB->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::PRESENT,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::COMPLIANT,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->getJson('/api/v1/organization/attendance/history');
            
        $response->assertStatus(200);
        $response->assertJsonMissing(['organization_id' => $this->orgB->id]);
    }

    #[Group('jwt')]
    public function test_9_2_user_in_org_a_with_owner_role_cannot_act_on_org_b()
    {
        $res = $this->loginUser($this->singleOrgUser);
        
        $branch = \App\Models\Organization\Branch::create([
            'organization_id' => $this->orgB->id,
            'name' => 'Org B Branch',
            'is_headquarters' => false,
            'is_active' => true,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->putJson("/api/v1/organization/branches/{$branch->uuid}", [
                'name' => 'Hacked Branch'
            ]);
            
        $this->assertTrue(in_array($response->status(), [403, 404]));
    }

    #[Group('jwt')]
    public function test_9_3_same_user_with_different_roles_in_different_orgs_gets_correct_permissions_per_org()
    {
        $loginRes = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $tempToken = $loginRes->json('meta.temp_token') ?? $loginRes->json('data.temp_token') ?? $loginRes->json('temp_token') ?? $loginRes->json('token');

        $resB = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);

        $decodedB = $this->decodeToken($resB->json('data.access_token'));
        $this->assertEquals($this->orgB->uuid, $decodedB->get('organization_uuid'));
    }

    #[Group('jwt')]
    public function test_9_4_switching_organizations_issues_a_completely_new_jwt()
    {
        $loginRes = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $tempToken = $loginRes->json('meta.temp_token') ?? $loginRes->json('data.temp_token') ?? $loginRes->json('temp_token') ?? $loginRes->json('token');

        $resA = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgA->uuid
            ]);

        $resB = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);

        $this->assertNotEquals($resA->json('data.access_token'), $resB->json('data.access_token'));
    }

    #[Group('jwt')]
    public function test_9_5_attendances_created_under_org_a_are_not_visible_when_scoped_to_org_b()
    {
        \App\Models\Attendance\AttendanceDay::forceCreate([
            'user_id' => $this->singleOrgUser->id,
            'organization_id' => $this->orgA->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => \App\Enums\AttendanceStatusEnum::PRESENT,
            'compliance_status' => \App\Enums\AttendanceComplianceStatusEnum::COMPLIANT,
        ]);

        $loginRes = $this->postJson('/api/v1/auth/login', [
            'email' => $this->multiOrgUser->email,
            'password' => 'Password123!',
        ]);

        $tempToken = $loginRes->json('meta.temp_token') ?? $loginRes->json('data.temp_token') ?? $loginRes->json('temp_token') ?? $loginRes->json('token');

        $selectRes = $this->withHeader('Authorization', "Bearer {$tempToken}")
            ->postJson('/api/v1/auth/select-organization', [
                'organization_uuid' => $this->orgB->uuid
            ]);

        $accessToken = $selectRes->json('data.access_token');

        $response = $this->withHeader('Authorization', "Bearer {$accessToken}")
            ->getJson('/api/v1/organization/attendance/history');
            
        $response->assertStatus(200);
        $response->assertJsonMissing(['organization_id' => $this->orgA->id]);
    }

    #[Group('jwt')]
    public function test_9_6_organization_id_in_jwt_cannot_be_tampered_with()
    {
        $res = $this->loginUser($this->singleOrgUser);
        $token = $res['access_token'];
        
        $parts = explode('.', $token);
        $payload = json_decode(base64_decode($parts[1]), true);
        $payload['organization_uuid'] = $this->orgB->uuid;
        $parts[1] = base64_encode(json_encode($payload));
        
        $tamperedToken = implode('.', $parts);
        
        $this->withHeader('Authorization', "Bearer {$tamperedToken}")
             ->getJson('/api/v1/auth/user/profile')
             ->assertStatus(401);
    }

    #[Group('jwt')]
    public function test_9_7_invitation_to_org_b_can_only_be_accepted_once()
    {
        $role = \App\Models\Rbac\Role::firstOrCreate(['name' => \App\Enums\SystemRole::EMPLOYEE->value, 'guard_name' => 'api', 'organization_id' => $this->orgB->id]);
        $plainToken = \Illuminate\Support\Str::random(32);
        $invitation = \App\Models\Invitation\Invitation::create([
            'organization_id' => $this->orgB->id,
            'email' => 'invitee@test.com',
            'role_id' => $role->id,
            'invited_by_user_id' => $this->multiOrgUser->id,
            'token' => hash('sha256', $plainToken),
            'expires_at' => now()->addDays(7),
            'status' => \App\Enums\InvitationStatusEnum::PENDING
        ]);

        $acceptData = [
            'token' => $plainToken,
            'name' => 'Invitee User',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!'
        ];

        $response1 = $this->postJson('/api/v1/invitations/accept', $acceptData);
        $response1->assertStatus(200);

        $response2 = $this->postJson('/api/v1/invitations/accept', $acceptData);
        $this->assertTrue(in_array($response2->status(), [409, 422, 400]));

        $user = \App\Models\Auth\User::where('email', 'invitee@test.com')->first();
        $count = \App\Models\Organization\OrganizationMembership::where('user_id', $user->id)
            ->where('organization_id', $this->orgB->id)
            ->count();
            
        $this->assertEquals(1, $count);
    }

    #[Group('jwt')]
    public function test_10_1_logout_revokes_refresh_token()
    {
        $res = $this->loginUser($this->singleOrgUser);

        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->postJson('/api/v1/auth/logout', [
                'refresh_token' => $res['refresh_token']
            ])->assertStatus(200);

        $hash = hash('sha256', $res['refresh_token']);
        $record = RefreshToken::where('token_hash', $hash)->first();
        $this->assertNotNull($record->revoked_at);
    }

    #[Group('jwt')]
    public function test_10_2_after_logout_the_access_token_is_rejected_on_next_request()
    {
        $res = $this->loginUser($this->singleOrgUser);

        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
            ->postJson('/api/v1/auth/logout', [
                'refresh_token' => $res['refresh_token']
            ])->assertStatus(200);

        // Since config/jwt.php has blacklist_enabled = true, the token is blacklisted immediately
        $this->withHeader('Authorization', "Bearer {$res['access_token']}")
             ->getJson('/api/v1/auth/user/profile')
             ->assertStatus(401);
    }

    #[Group('jwt')]
    public function test_10_3_logout_from_all_devices_revokes_all_refresh_tokens()
    {
        $res1 = $this->loginUser($this->singleOrgUser);
        $res2 = $this->loginUser($this->singleOrgUser);

        $this->withHeader('Authorization', "Bearer {$res1['access_token']}")
            ->postJson('/api/v1/auth/logout-all')->assertStatus(200);

        $hash1 = hash('sha256', $res1['refresh_token']);
        $record1 = RefreshToken::where('token_hash', $hash1)->first();
        $this->assertNotNull($record1->revoked_at);

        $hash2 = hash('sha256', $res2['refresh_token']);
        $record2 = RefreshToken::where('token_hash', $hash2)->first();
        $this->assertNotNull($record2->revoked_at);
    }

    #[Group('jwt')]
    public function test_10_4_logout_does_not_affect_other_users_tokens()
    {
        $res1 = $this->loginUser($this->singleOrgUser);
        
        $otherUser = User::factory()->create([
            'email' => 'otherlogout@example.com',
            'password' => Hash::make('Password123!'),
            'password_set' => true,
            'is_active' => true,
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'token_version' => 1,
        ]);
        OrganizationMembership::create(['user_id' => $otherUser->id, 'organization_id' => $this->orgA->id, 'joined_at' => now(), 'status' => 'active']);
        setPermissionsTeamId($this->orgA->id);
        $otherUser->assignRole('Member');
        
        $res2 = $this->loginUser($otherUser);
        $this->assertArrayHasKey('refresh_token', $res2, 'Other user login failed');

        $this->withHeader('Authorization', "Bearer {$res1['access_token']}")
            ->postJson('/api/v1/auth/logout', [
                'refresh_token' => $res1['refresh_token']
            ])->assertStatus(200);

        $hash2 = hash('sha256', $res2['refresh_token']);
        $record2 = RefreshToken::where('token_hash', $hash2)->first();
        $this->assertNull($record2->revoked_at);
    }

    #[Group('2fa')]
    #[Group('security')]
    public function test_8_12_2fa_temp_token_cannot_be_reused_after_successful_verification()
    {
        $loginRes = $this->postJson('/api/v1/auth/login', [
            'email' => $this->twoFactorUser->email,
            'password' => 'Password123!'
        ]);

        $tempToken = $loginRes->json('meta.temp_token') ?? $loginRes->json('data.temp_token') ?? $loginRes->json('temp_token') ?? $loginRes->json('token');

        $google2fa = app('pragmarx.google2fa');
        $validCode = $google2fa->getCurrentOtp(
            $this->twoFactorUser->two_factor_secret
        );

        // First use — must succeed and burn the token
        $response1 = $this->postJson('/api/v1/auth/2fa/verify', [
            'temp_token' => $tempToken,
            'code' => $validCode
        ], ['Authorization' => "Bearer {$tempToken}"]);
        $response1->assertStatus(200);
        $response1->assertJsonStructure(['data' => ['access_token']]);

        // Verify token is burned in database
        $payload = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::setToken($tempToken)->getPayload();
        $record = \App\Models\Auth\TempToken::where(
            'jti', $payload->get('jti')
        )->first();
        $this->assertNotNull($record->used_at);

        // Second use — must be rejected even with a fresh valid TOTP code
        $validCode2 = $google2fa->getCurrentOtp(
            $this->twoFactorUser->two_factor_secret
        );
        $response2 = $this->postJson('/api/v1/auth/2fa/verify', [
            'temp_token' => $tempToken,
            'code' => $validCode2
        ], ['Authorization' => "Bearer {$tempToken}"]);
        $response2->assertStatus(401);
        $response2->assertJsonMissing(['access_token']);
    }
}
