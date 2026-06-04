<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Jobs\Auth\SendVerificationEmailJob;
use App\Mail\Auth\VerifyEmailMail;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    // ─── Registration Dispatches Email ──────────────────────────────

    public function test_registration_dispatches_verification_email_job(): void
    {
        Queue::fake();

        $this->postJson('/api/v1/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertCreated();

        Queue::assertPushed(SendVerificationEmailJob::class, function ($job) {
            return $job->user->email === 'john@example.com'
                && str_contains($job->verificationUrl, '/verify-email?token=');
        });
    }

    // ─── Email Contains Correct URL ─────────────────────────────────

    public function test_verification_email_contains_correct_raw_token_url(): void
    {
        Mail::fake();

        $this->postJson('/api/v1/auth/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertCreated();

        Mail::assertSent(VerifyEmailMail::class, function ($mail) {
            return $mail->hasTo('jane@example.com')
                && str_contains($mail->verificationUrl, '/verify-email?token=')
                && strlen($mail->verificationUrl) > 60; // URL + 64-char token
        });
    }

    // ─── Database Stores Only Hashed Token ──────────────────────────

    public function test_database_stores_only_hashed_token_never_raw(): void
    {
        Queue::fake();

        $this->postJson('/api/v1/auth/register', [
            'name' => 'Token User',
            'email' => 'token@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ])->assertCreated();

        $user = User::where('email', 'token@example.com')->first();

        // Token must be a SHA-256 hex hash (64 hex chars)
        $this->assertNotNull($user->email_verification_token);
        $this->assertEquals(64, strlen($user->email_verification_token));
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $user->email_verification_token);

        // Expiry must be set
        $this->assertNotNull($user->email_verification_token_expires_at);

        // Verify the stored token is NOT the raw token from the queued job
        Queue::assertPushed(SendVerificationEmailJob::class, function ($job) use ($user) {
            // Extract raw token from URL
            $urlParts = parse_url($job->verificationUrl);
            parse_str($urlParts['query'] ?? '', $queryParams);
            $rawToken = $queryParams['token'] ?? '';

            // The stored hash must equal SHA-256 of the raw token
            return hash('sha256', $rawToken) === $user->email_verification_token;
        });
    }

    // ─── Valid Token Verifies Email ──────────────────────────────────

    public function test_user_can_verify_email_with_valid_token(): void
    {
        $rawToken = str_repeat('a', 64);

        $user = User::factory()->unverified()->create([
            'email_verification_token' => hash('sha256', $rawToken),
            'email_verification_token_expires_at' => now()->addMinutes(60),
        ]);

        $response = $this->postJson('/api/v1/auth/verify-email', [
            'token' => $rawToken,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->email_verification_token);
        $this->assertNull($user->email_verification_token_expires_at);
    }

    // ─── Expired Token Fails ────────────────────────────────────────

    public function test_expired_token_is_rejected(): void
    {
        $rawToken = str_repeat('c', 64);

        User::factory()->unverified()->create([
            'email_verification_token' => hash('sha256', $rawToken),
            'email_verification_token_expires_at' => now()->subMinutes(1),
        ]);

        $response = $this->postJson('/api/v1/auth/verify-email', [
            'token' => $rawToken,
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonPath('success', false);
    }

    // ─── Token Cannot Be Reused ─────────────────────────────────────

    public function test_token_cannot_be_reused_after_verification(): void
    {
        $rawToken = str_repeat('d', 64);

        User::factory()->unverified()->create([
            'email_verification_token' => hash('sha256', $rawToken),
            'email_verification_token_expires_at' => now()->addMinutes(60),
        ]);

        // First verification succeeds
        $this->postJson('/api/v1/auth/verify-email', [
            'token' => $rawToken,
        ])->assertOk();

        // Second attempt with same token fails
        $this->postJson('/api/v1/auth/verify-email', [
            'token' => $rawToken,
        ])->assertStatus(401);
    }

    // ─── Login Blocked Before Verification ──────────────────────────

    public function test_login_is_blocked_before_email_verification(): void
    {
        $user = User::factory()->unverified()->create([
            'password' => 'Password1!',
            'email_verification_token' => hash('sha256', str_repeat('e', 64)),
            'email_verification_token_expires_at' => now()->addMinutes(60),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonPath('success', false);
    }

    // ─── Login Allowed After Verification ───────────────────────────

    public function test_login_succeeds_after_email_verification(): void
    {
        $rawToken = str_repeat('f', 64);

        $user = User::factory()->unverified()->create([
            'password' => 'Password1!',
            'email_verification_token' => hash('sha256', $rawToken),
            'email_verification_token_expires_at' => now()->addMinutes(60),
        ]);

        // Verify email first
        $this->postJson('/api/v1/auth/verify-email', [
            'token' => $rawToken,
        ])->assertOk();

        // Now login should work
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    // ─── Resend Endpoint Always Returns Same Message ────────────────

    public function test_resend_endpoint_returns_constant_message_regardless_of_email_existence(): void
    {
        // Non-existent email
        $response = $this->postJson('/api/v1/auth/resend-verification-email', [
            'email' => 'nonexistent@example.com',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'If your account exists, a verification email has been sent.');

        // Existing unverified user
        Queue::fake();

        User::factory()->unverified()->create([
            'email' => 'real@example.com',
            'email_verification_token' => hash('sha256', str_repeat('g', 64)),
            'email_verification_token_expires_at' => now()->addMinutes(60),
        ]);

        $response = $this->postJson('/api/v1/auth/resend-verification-email', [
            'email' => 'real@example.com',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'If your account exists, a verification email has been sent.');

        Queue::assertPushed(SendVerificationEmailJob::class);
    }
}
