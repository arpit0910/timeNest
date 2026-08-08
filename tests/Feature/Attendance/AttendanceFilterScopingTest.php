<?php

declare(strict_types=1);

namespace Tests\Feature\Attendance;

use App\Enums\AttendanceComplianceStatusEnum;
use App\Enums\AttendanceStatusEnum;
use App\Enums\MembershipStatus;
use App\Enums\SystemPermission;
use App\Enums\SystemRole;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Auth\User;
use App\Models\Membership\EmployeeProfile;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use Database\Seeders\OrganizationRolePermissionsSeeder;
use Database\Seeders\PlatformPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceFilterScopingTest extends TestCase
{
    use RefreshDatabase;

    private Organization $organization;
    private User $admin;
    private User $manager;
    private User $employee1;
    private User $employee2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PlatformPermissionsSeeder::class);
        $this->seed(OrganizationRolePermissionsSeeder::class);

        $this->organization = Organization::create([
            'legal_name' => 'Acme Corp',
            'slug' => 'acme-corp',
            'is_active' => true,
        ]);

        $this->admin = User::factory()->create(['name' => 'Admin User']);
        $this->manager = User::factory()->create(['name' => 'Manager User']);
        $this->employee1 = User::factory()->create(['name' => 'Employee 1']);
        $this->employee2 = User::factory()->create(['name' => 'Employee 2']);

        foreach ([$this->admin, $this->manager, $this->employee1, $this->employee2] as $user) {
            OrganizationMembership::create([
                'user_id' => $user->id,
                'organization_id' => $this->organization->id,
                'status' => MembershipStatus::ACTIVE,
                'joined_at' => now(),
            ]);
        }

        EmployeeProfile::create([
            'user_id' => $this->employee1->id,
            'organization_id' => $this->organization->id,
            'reports_to' => $this->manager->id,
            'employee_code' => 'EMP-001',
        ]);

        EmployeeProfile::create([
            'user_id' => $this->employee2->id,
            'organization_id' => $this->organization->id,
            'reports_to' => null,
            'employee_code' => 'EMP-002',
        ]);

        $superAdminRole = Role::where('name', SystemRole::FREELANCE_SUPER_ADMIN->value)->firstOrFail();
        $memberRole = Role::where('name', SystemRole::FREELANCE_MEMBER->value)->firstOrFail();

        setPermissionsTeamId($this->organization->id);
        $this->admin->assignRole($superAdminRole);
        $this->manager->assignRole($memberRole);
        $this->manager->givePermissionTo(SystemPermission::ATTENDANCE_VIEW->value);
        $this->manager->givePermissionTo(SystemPermission::ATTENDANCE_APPROVE->value);
        $this->manager->givePermissionTo(SystemPermission::ATTENDANCE_ESCALATIONS_VIEW->value);
        $this->manager->givePermissionTo(SystemPermission::WORKLOG_VIEW->value);

        $this->employee1->assignRole($memberRole);
        $this->employee1->givePermissionTo(SystemPermission::ATTENDANCE_VIEW->value);
        $this->employee1->givePermissionTo(SystemPermission::WORKLOG_VIEW->value);

        $this->employee2->assignRole($memberRole);
        $this->employee2->givePermissionTo(SystemPermission::ATTENDANCE_VIEW->value);
        setPermissionsTeamId(null);
    }

    public function test_attendance_day_resource_includes_user_object(): void
    {
        $day = AttendanceDay::create([
            'user_id' => $this->employee1->id,
            'organization_id' => $this->organization->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => AttendanceStatusEnum::INCOMPLETE,
            'compliance_status' => AttendanceComplianceStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($this->employee1)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/today');

        $response->assertStatus(200)
            ->assertJsonPath('data.user.uuid', $this->employee1->uuid)
            ->assertJsonPath('data.user.name', 'Employee 1')
            ->assertJsonPath('data.user.employee_code', 'EMP-001');
    }

    public function test_manager_can_view_subordinate_history_using_user_uuid(): void
    {
        AttendanceDay::create([
            'user_id' => $this->employee1->id,
            'organization_id' => $this->organization->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => AttendanceStatusEnum::INCOMPLETE,
            'compliance_status' => AttendanceComplianceStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($this->manager)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/history?user_uuid=' . $this->employee1->uuid);

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_manager_cannot_view_non_subordinate_history_throws_403(): void
    {
        AttendanceDay::create([
            'user_id' => $this->employee2->id,
            'organization_id' => $this->organization->id,
            'attendance_date' => now()->toDateString(),
            'attendance_status' => AttendanceStatusEnum::INCOMPLETE,
            'compliance_status' => AttendanceComplianceStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($this->manager)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/history?user_uuid=' . $this->employee2->uuid);

        $response->assertStatus(403)
            ->assertJsonPath('error_code', 'CANNOT_VIEW_USER_ATTENDANCE');
    }

    public function test_non_manager_requesting_other_user_uuid_throws_403_insufficient_scope(): void
    {
        $response = $this->actingAs($this->employee1)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/adjustments?user_uuid=' . $this->employee2->uuid);

        $response->assertStatus(403)
            ->assertJsonPath('error_code', 'INSUFFICIENT_SCOPE');
    }

    public function test_adjustments_and_escalations_and_worklogs_are_paginated(): void
    {
        $responseWorklogs = $this->actingAs($this->admin)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/worklogs?per_page=10');

        $responseWorklogs->assertStatus(200);

        $responseAdjustments = $this->actingAs($this->admin)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/adjustments?per_page=10');

        $responseAdjustments->assertStatus(200);

        $responseEscalations = $this->actingAs($this->admin)
            ->withHeader('X-Organization-Id', (string) $this->organization->id)
            ->getJson('/api/v1/attendance/escalations?per_page=10');

        $responseEscalations->assertStatus(200);
    }
}
