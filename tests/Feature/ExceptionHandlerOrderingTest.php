<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ExceptionHandlerOrderingTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsTenant(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');

        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user,
            $org,
            \App\Enums\Guard::ORGANIZATION,
            'Manager'
        );
        $this->withToken($token);

        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);

        return $this;
    }

    public function test_nonexistent_uuid_now_returns_404_not_403(): void
    {
        $user = User::factory()->create();
        $org = Organization::create([
            'legal_name' => 'Test Org',
            'slug' => 'test-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($org->id);
        $p = Permission::where('name', \App\Enums\SystemPermission::WORKLOG_VIEW->value)->where('guard_name', 'api')->first();
        if ($p) {
            $user->givePermissionTo($p);
        }
        setPermissionsTeamId(null);

        $response = $this->actingAsTenant($user, $org)
            ->getJson('/api/v1/organization/attendance/worklogs/' . (string) Str::uuid());

        echo "\n=== NONEXISTENT UUID ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(404);
    }

    public function test_genuine_permission_denial_still_returns_403(): void
    {
        $user = User::factory()->create();
        $org = Organization::create([
            'legal_name' => 'Test Org',
            'slug' => 'test-org-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);
        // Deliberately grant NO permissions at all.

        $response = $this->actingAsTenant($user, $org)
            ->getJson('/api/v1/organization/attendance/worklogs');

        echo "\n=== GENUINE PERMISSION DENIAL ===\nStatus: {$response->status()}\nBody: {$response->getContent()}\n";

        $response->assertStatus(403);
    }
}
