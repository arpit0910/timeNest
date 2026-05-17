<?php

namespace Tests\Feature\Auth;

use App\Actions\IssueJwtAction;
use App\Enums\Guard;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_change_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $token = app(IssueJwtAction::class)->issueAccessToken($user, null, Guard::Platform);

        $response = $this
            ->withToken($token)
            ->postJson('/api/v1/auth/change-password', [
                'current_password' => 'Password1!',
                'password' => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertTrue(Hash::check('NewPassword1!', $user->fresh()->password));
        $this->assertSame(2, $user->fresh()->token_version);
    }
}
