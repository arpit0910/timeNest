<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2FALaravel\Facade as Google2FA;
use Tests\TestCase;

class TwoFactorTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'password' => bcrypt('password123'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $corpId = \Illuminate\Support\Facades\DB::table('corporations')->insertGetId([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'legal_name' => 'Test Corp',
            'trading_name' => 'Test Corp',
            'slug' => 'test-corp',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roleId = \Illuminate\Support\Facades\DB::table('roles')->insertGetId([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Owner',
            'guard_name' => 'api',
            'corporation_id' => $corpId,
            'is_system_role' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id' => $roleId,
            'model_type' => \App\Models\Auth\User::class,
            'model_id' => $this->user->id,
            'corporation_id' => $corpId,
        ]);

        \Illuminate\Support\Facades\DB::table('corp_memberships')->insert([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'corporation_id' => $corpId,
            'user_id' => $this->user->id,
            'status' => 'active',
            'joined_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function getAuthToken(): string
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);
        
        return $response->json('data.access_token');
    }

    public function test_can_get_status(): void
    {
        $token = $this->getAuthToken();
        
        $response = $this->withToken($token)->getJson('/api/v1/auth/user/2fa/status');

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'enabled' => false,
                    'enabled_at' => null,
                ],
            ]);
    }

    public function test_can_initiate_setup(): void
    {
        $token = $this->getAuthToken();
        
        $response = $this->withToken($token)->postJson('/api/v1/auth/user/2fa/setup/initiate');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'secret',
                    'qr_code_url',
                    'manual_entry_key',
                ],
            ]);

        // Secret should be cached
        $this->assertNotNull(Cache::get("2fa_setup_secret_{$this->user->id}"));
    }

    public function test_can_confirm_setup(): void
    {
        $token = $this->getAuthToken();
        
        $secret = Google2FA::generateSecretKey();
        Cache::put("2fa_setup_secret_{$this->user->id}", $secret, now()->addMinutes(10));

        $code = Google2FA::getCurrentOtp($secret);

        $response = $this->withToken($token)->postJson('/api/v1/auth/user/2fa/setup/confirm', [
            'code' => $code,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'recovery_codes',
                ],
            ]);

        $this->user->refresh();
        $this->assertNotNull($this->user->two_factor_secret);
        $this->assertNotNull($this->user->two_factor_enabled_at);
        $this->assertCount(8, $this->user->two_factor_recovery_codes);
        $this->assertNull(Cache::get("2fa_setup_secret_{$this->user->id}"));
    }

    public function test_cannot_confirm_setup_with_invalid_code(): void
    {
        $token = $this->getAuthToken();
        
        $secret = Google2FA::generateSecretKey();
        Cache::put("2fa_setup_secret_{$this->user->id}", $secret, now()->addMinutes(10));

        $response = $this->withToken($token)->postJson('/api/v1/auth/user/2fa/setup/confirm', [
            'code' => '000000',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);

        $this->user->refresh();
        $this->assertNull($this->user->two_factor_secret);
    }

    public function test_login_requires_2fa_if_enabled(): void
    {
        $this->user->update([
            'two_factor_secret' => Google2FA::generateSecretKey(),
            'two_factor_enabled_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJson([
                'status' => '2fa_required',
            ])
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function test_can_verify_2fa_during_login(): void
    {
        $secret = Google2FA::generateSecretKey();
        $this->user->update([
            'two_factor_secret' => $secret,
            'two_factor_enabled_at' => now(),
        ]);

        // Login to get temp token
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);
        $tempToken = $loginResponse->json('token');

        $code = Google2FA::getCurrentOtp($secret);

        $response = $this->withToken($tempToken)->postJson('/api/v1/auth/2fa/verify', [
            'code' => $code,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                ],
            ]);
    }

    public function test_can_verify_2fa_using_recovery_code(): void
    {
        $plainCode = '12345-67890';
        $hashedCode = hash('sha256', $plainCode);

        $this->user->update([
            'two_factor_secret' => Google2FA::generateSecretKey(),
            'two_factor_enabled_at' => now(),
            'two_factor_recovery_codes' => [$hashedCode],
        ]);

        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);
        $tempToken = $loginResponse->json('token');

        $response = $this->withToken($tempToken)->postJson('/api/v1/auth/2fa/verify', [
            'code' => $plainCode,
        ]);

        $response->assertOk();

        $this->user->refresh();
        $this->assertEmpty($this->user->two_factor_recovery_codes);
    }

    public function test_can_disable_2fa(): void
    {
        $secret = Google2FA::generateSecretKey();
        $this->user->update([
            'two_factor_secret' => $secret,
            'two_factor_enabled_at' => now(),
            'two_factor_recovery_codes' => ['some_hash'],
        ]);

        // Need to login via 2FA to get a valid token
        $loginResponse = $this->postJson('/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);
        $tempToken = $loginResponse->json('token');
        
        $code = Google2FA::getCurrentOtp($secret);
        
        $verifyResponse = $this->withToken($tempToken)->postJson('/api/v1/auth/2fa/verify', [
            'code' => $code,
        ]);
        $token = $verifyResponse->json('data.access_token');

        $response = $this->withToken($token)->postJson('/api/v1/auth/user/2fa/disable', [
            'code' => $code,
        ]);

        $response->assertOk();

        $this->user->refresh();
        $this->assertNull($this->user->two_factor_secret);
        $this->assertNull($this->user->two_factor_enabled_at);
        $this->assertNull($this->user->two_factor_recovery_codes);
    }
}
