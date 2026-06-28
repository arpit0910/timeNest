<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Organization\AddMemberRequest;
use App\Http\Resources\Organization\OrganizationMembershipResource;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Models\Rbac\Role;
use App\Services\Organization\MembershipService;
use App\Http\Requests\Organization\UpdateMemberRoleRequest;
use Illuminate\Http\JsonResponse;

/**
 * Organization-scoped membership management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → organization.access → tenant.resolve → permission:users.*
 *
 * Tenant context: resolved via app('tenant.organization') — set by ResolveTenantContext middleware.
 * This controller contains ZERO authorization or tenant extraction logic.
 */
class MembershipController extends BaseApiController
{
    public function __construct(
        private readonly MembershipService $membershipService,
    ) {}

    /**
     * Resolve the active organization from the container.
     */
    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all members of the active organization.
     */
    public function index(): JsonResponse
    {
        $organization = $this->getOrganization();

        $memberships = OrganizationMembership::where('organization_id', $organization->id)
            ->with(['user.roles'])
            ->paginate(50);

        return $this->success(OrganizationMembershipResource::collection($memberships)->response()->getData(true));
    }

    /**
     * Directly add a user to the organization.
     */
    public function store(AddMemberRequest $request): JsonResponse
    {
        $organization = $this->getOrganization();
        $user = User::where('uuid', $request->input('user_uuid'))->firstOrFail();
        $role = Role::where('uuid', $request->input('role_uuid'))->firstOrFail();

        // Prevent adding a user who is already a member
        if (OrganizationMembership::where('organization_id', $organization->id)->where('user_id', $user->id)->exists()) {
            throw new BusinessRuleViolationException('User is already a member of this organization');
        }

        // Resolve UUIDs to IDs
        $departmentId = $request->input('department_uuid') ? \App\Models\Organization\Department::where('uuid', $request->input('department_uuid'))->value('id') : null;
        $branchId = $request->input('branch_uuid') ? \App\Models\Organization\Branch::where('uuid', $request->input('branch_uuid'))->value('id') : null;
        $reportsToId = $request->input('reports_to_uuid') ? User::where('uuid', $request->input('reports_to_uuid'))->value('id') : null;

        $subDepartmentId = $request->input('sub_department_uuid') ? \App\Models\Organization\SubDepartment::where('uuid', $request->input('sub_department_uuid'))->value('id') : null;
        $designationId = $request->input('designation_uuid') ? \App\Models\Organization\Designation::where('uuid', $request->input('designation_uuid'))->value('id') : null;

        $employeeData = $request->only(['employee_code', 'employment_type', 'joining_date']);
        $employeeData['department_id'] = $departmentId;
        $employeeData['sub_department_id'] = $subDepartmentId;
        $employeeData['designation_id'] = $designationId;
        $employeeData['branch_id'] = $branchId;
        $employeeData['reports_to'] = $reportsToId;

        $membership = $this->membershipService->addMember(
            organization: $organization,
            user: $user,
            role: $role,
            employeeData: $employeeData,
            invitedById: $request->user()->id
        );

        return $this->created(new OrganizationMembershipResource($membership->load(['user.roles'])), 'Member added successfully');
    }

    /**
     * Deactivate a member.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $membership = OrganizationMembership::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->membershipService->deactivateMember($membership);

        return $this->success(message: 'Member deactivated successfully');
    }

    /**
     * View a single member.
     */
    public function show(string $uuid): JsonResponse
    {
        $organizationId = $this->getOrganization()->id;

        $membership = OrganizationMembership::where('uuid', $uuid)
            ->where('organization_id', $organizationId)
            ->with(['user.roles', 'department', 'subDepartment', 'designation'])
            ->firstOrFail();

        return $this->success(new OrganizationMembershipResource($membership));
    }

    /**
     * Update a member's role.
     */
    public function updateRole(UpdateMemberRoleRequest $request, string $uuid): JsonResponse
    {
        $organizationId = $this->getOrganization()->id;

        $membership = OrganizationMembership::where('uuid', $uuid)
            ->where('organization_id', $organizationId)
            ->firstOrFail();

        $role = Role::where('uuid', $request->validated('role_uuid'))->firstOrFail();

        $updated = $this->membershipService->changeRole(
            $membership,
            $role
        );

        return $this->success(new OrganizationMembershipResource($updated->load(['user.roles', 'department', 'subDepartment', 'designation'])));
    }
}
