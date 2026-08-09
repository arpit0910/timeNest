<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Rbac\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AttendancePolicyVersionsTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsTenant(User $user, Organization $org): self
    {
        $this->actingAs($user, 'api');
        $token = app(\App\Actions\IssueJwtAction::class)->issueAccessToken(
            $user, $org, \App\Enums\Guard::ORGANIZATION, 'Manager'
        );
        $this->withToken($token);
        $this->app->instance('tenant.organization', $org);
        $this->withoutMiddleware([\App\Http\Middleware\EnsureOrganizationAccess::class]);
        return $this;
    }

    public function test_versions_endpoint_returns_snapshot_history(): void
    {
        $user = User::factory()->create();
        $org = Organization::create([
            'legal_name' => 'Policy Versions Org',
            'slug' => 'policy-versions-' . uniqid(),
            'type' => \App\Enums\Organization\OrganizationType::ORGANIZATION->value,
            'is_active' => true,
        ]);
        $org->users()->attach($user->id, ['uuid' => (string) Str::uuid(), 'status' => 'active', 'joined_at' => now()]);

        setPermissionsTeamId($org->id);
        foreach (['ATTENDANCE_POLICY_VIEW', 'ATTENDANCE_POLICY_MANAGE'] as $perm) {
            $p = Permission::where('name', \App\Enums\SystemPermission::{$perm}->value)->where('guard_name', 'api')->first();
            if ($p) {
                $user->givePermissionTo($p);
            }
        }
        setPermissionsTeamId(null);

        $this->actingAsTenant($user, $org);

        // First GET auto-provisions the default policy -> version 1.
        $this->getJson('/api/v1/organization/attendance/policy')->assertStatus(200);

        // Update -> version 2.
        $update = $this->putJson('/api/v1/organization/attendance/policy', ['required_daily_minutes' => 500]);
        $update->assertStatus(200);

        $versions = $this->getJson('/api/v1/organization/attendance/policy/versions');

        echo "\n=== ATTENDANCE POLICY VERSIONS ===\nStatus: {$versions->status()}\nBody: {$versions->getContent()}\n";

        $versions->assertStatus(200);
        $data = $versions->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals(2, $data[0]['version']);
        $this->assertEquals(500, $data[0]['required_daily_minutes']);
        $this->assertEquals(1, $data[1]['version']);
    }
}
