<?php

namespace Tests\Feature\Auth;

use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Models\Rbac\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_users_can_authenticate_through_the_api(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'no_workspace');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response
            ->assertUnauthorized()
            ->assertJsonPath('success', false);
    }

    public function test_corporation_member_can_authenticate_without_global_spatie_team_context(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password1!'),
            'email_verified_at' => now(),
        ]);

        $corporation = Corporation::create([
            'legal_name' => 'Acme Technologies Private Limited',
            'slug' => 'acme-tech',
            'is_active' => true,
            'is_verified' => true,
        ]);

        $role = Role::create([
            'name' => SystemRole::CorpOwner->value,
            'guard_name' => 'api',
            'corporation_id' => null,
            'is_system_role' => true,
        ]);

        CorpMembership::create([
            'user_id' => $user->id,
            'corporation_id' => $corporation->id,
            'status' => MembershipStatus::Active,
            'joined_at' => now(),
        ]);

        setPermissionsTeamId($corporation->id);
        $user->assignRole($role);
        setPermissionsTeamId(null);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'Password1!',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'authenticated')
            ->assertJsonPath('data.guard', 'corp')
            ->assertJsonPath('data.role', SystemRole::CorpOwner->value);
    }
}
