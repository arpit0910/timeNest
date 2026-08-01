<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Enums\AccountType;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register_through_the_api(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
            'account_type' => AccountType::FREELANCER->value,
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'registered');

        $this->assertDatabaseHas(User::class, [
            'email' => 'test@example.com',
        ]);
    }

    public function test_freelancer_registration_ignores_an_extra_organization_name(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Solo User',
            'email' => 'solo@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
            'account_type' => AccountType::FREELANCER->value,
            'organization_name' => 'Ignored Name',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas(User::class, [
            'email' => 'solo@example.com',
            'account_type' => AccountType::FREELANCER->value,
        ]);
        $this->assertSame(0, Organization::query()->count());
    }

    public function test_registration_requires_a_valid_account_type(): void
    {
        $payload = [
            'name' => 'Validation User',
            'email' => 'validation@example.com',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ];

        $this->postJson('/api/v1/auth/register', $payload)
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Validation failed')
            ->assertJsonStructure(['errors' => ['account_type']]);

        $this->postJson('/api/v1/auth/register', [...$payload, 'account_type' => 'xyz'])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Validation failed')
            ->assertJsonStructure(['errors' => ['account_type']]);
    }
}
