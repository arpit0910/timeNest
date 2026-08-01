<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\AttendanceStatusEnum;
use App\Enums\MembershipStatus;
use App\Enums\SystemRole;
use App\Models\Attendance\AttendanceDay;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use Database\Seeders\OrganizationRolePermissionsSeeder;
use Database\Seeders\PlatformPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AttendanceDayPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_freelance_members_only_view_their_own_attendance_day(): void
    {
        $this->seed(PlatformPermissionsSeeder::class);
        $this->seed(OrganizationRolePermissionsSeeder::class);

        $organization = Organization::create([
            'legal_name' => 'Freelance Team',
            'slug' => 'freelance-team',
            'is_active' => true,
        ]);
        $member = User::factory()->create();
        $otherMember = User::factory()->create();
        $superAdmin = User::factory()->create();

        foreach ([$member, $otherMember, $superAdmin] as $user) {
            OrganizationMembership::create([
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'status' => MembershipStatus::ACTIVE,
                'joined_at' => now(),
            ]);
        }

        $memberRole = Role::where('name', SystemRole::FREELANCE_MEMBER->value)->firstOrFail();
        $superAdminRole = Role::where('name', SystemRole::FREELANCE_SUPER_ADMIN->value)->firstOrFail();
        setPermissionsTeamId($organization->id);
        $member->assignRole($memberRole);
        $superAdmin->assignRole($superAdminRole);
        setPermissionsTeamId(null);

        $ownDay = AttendanceDay::create([
            'user_id' => $member->id,
            'organization_id' => $organization->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => AttendanceStatusEnum::INCOMPLETE,
            'compliance_status' => AttendanceComplianceStatusEnum::PENDING,
        ]);
        $otherDay = AttendanceDay::create([
            'user_id' => $otherMember->id,
            'organization_id' => $organization->id,
            'attendance_date' => now()->subDay()->toDateString(),
            'attendance_status' => AttendanceStatusEnum::INCOMPLETE,
            'compliance_status' => AttendanceComplianceStatusEnum::PENDING,
        ]);

        app()->instance('tenant.organization', $organization);
        setPermissionsTeamId($organization->id);

        $this->assertTrue(Gate::forUser($member)->allows('view', $ownDay));
        $this->assertFalse(Gate::forUser($member)->allows('view', $otherDay));
        $this->assertTrue(Gate::forUser($superAdmin)->allows('view', $otherDay));

        setPermissionsTeamId(null);
    }
}
