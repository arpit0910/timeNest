<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\Auth\PasswordResetToken;
use App\Models\Auth\User;
use App\Notifications\Auth\PasswordChangedNotification;
use App\Notifications\Auth\PasswordResetRequestedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_forgot_password_sends_notification(): void
    {
        Notification::fake();

        $response = $this->postJson('/api/v1/auth/forgot-password', [
            'email' => $this->user->email,
        ]);

        $response->assertOk();
        $response->assertJsonPath('message', 'If an account with that email exists, a password reset token has been sent.');

        Notification::assertSentTo(
            [$this->user],
            PasswordResetRequestedNotification::class
        );

        $this->assertDatabaseCount('password_reset_tokens', 1);
    }

    public function test_forgot_password_does_not_reveal_missing_email(): void
    {
        Notification::fake();

        $response = $this->postJson('/api/v1/auth/forgot-password', [
            'email' => 'nobody@example.com',
        ]);

        $response->assertOk();
        $response->assertJsonPath('message', 'If an account with that email exists, a password reset token has been sent.');

        Notification::assertNothingSent();
    }

    public function test_reset_password_success(): void
    {
        Notification::fake();

        $this->postJson('/api/v1/auth/forgot-password', [
            'email' => $this->user->email,
        ]);

        $tokenRecord = PasswordResetToken::where('user_id', $this->user->id)->first();
        
        $plainToken = null;
        Notification::assertSentTo($this->user, PasswordResetRequestedNotification::class, function ($notification) use (&$plainToken) {
            $plainToken = $notification->plainToken;
            return true;
        });

        $response = $this->postJson('/api/v1/auth/reset-password', [
            'email' => $this->user->email,
            'token' => $plainToken,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertOk();
        $response->assertJsonPath('message', 'Password has been reset successfully. Please log in.');

        Notification::assertSentTo(
            [$this->user],
            PasswordChangedNotification::class
        );

        $tokenRecord->refresh();
        $this->assertNotNull($tokenRecord->used_at);

        $this->user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $this->user->password));
    }

    public function test_reset_password_fails_with_invalid_token(): void
    {
        $response = $this->postJson('/api/v1/auth/reset-password', [
            'email' => $this->user->email,
            'token' => 'invalid-token-here-with-64-characters-0000000000000000000000000',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertStatus(422);
    }
}
