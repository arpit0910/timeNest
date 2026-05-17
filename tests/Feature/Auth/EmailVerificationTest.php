<?php

namespace Tests\Feature\Auth;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_can_be_verified_with_api_token(): void
    {
        $token = str_repeat('a', 64);
        $user = User::factory()->unverified()->create([
            'email_verification_token' => hash('sha256', $token),
        ]);

        $response = $this->postJson('/api/v1/auth/verify-email', [
            'token' => $token,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertNull($user->fresh()->email_verification_token);
    }

    public function test_email_is_not_verified_with_invalid_api_token(): void
    {
        User::factory()->unverified()->create([
            'email_verification_token' => hash('sha256', str_repeat('a', 64)),
        ]);

        $response = $this->postJson('/api/v1/auth/verify-email', [
            'token' => str_repeat('b', 64),
        ]);

        $response
            ->assertStatus(400)
            ->assertJsonPath('success', false);
    }
}
