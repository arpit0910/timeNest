<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Corporation\AddMemberRequest;
use App\Http\Resources\Corporation\CorpMembershipResource;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Models\Rbac\Role;
use App\Services\Corporation\MembershipService;
use Illuminate\Http\JsonResponse;

/**
 * Corporation-scoped membership management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → corp.access → tenant.resolve → permission:users.*
 *
 * Tenant context: resolved via app('tenant.corporation') — set by ResolveTenantContext middleware.
 * This controller contains ZERO authorization or tenant extraction logic.
 */
class MembershipController extends BaseApiController
{
    public function __construct(
        private readonly MembershipService $membershipService,
    ) {}

    /**
     * Resolve the active corporation from the container.
     */
    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * List all members of the active corporation.
     */
    public function index(): JsonResponse
    {
        $memberships = CorpMembership::where('corporation_id', $this->tenant()->id)
            ->with(['user.roles'])
            ->paginate(50);

        return $this->success(CorpMembershipResource::collection($memberships)->response()->getData(true));
    }

    /**
     * Directly add a user to the corporation.
     */
    public function store(AddMemberRequest $request): JsonResponse
    {
        $corp = $this->tenant();
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::findOrFail($request->input('role_id'));

        // Prevent adding a user who is already a member
        if (CorpMembership::where('corporation_id', $corp->id)->where('user_id', $user->id)->exists()) {
            throw new BusinessRuleViolationException('User is already a member of this corporation');
        }

        $membership = $this->membershipService->addMember(
            corp: $corp,
            user: $user,
            role: $role,
            employeeData: $request->only([
                'employee_code', 'designation', 'department_id', 'branch_id',
                'employment_type', 'joining_date', 'reports_to',
            ]),
            invitedById: $request->user()->id
        );

        return $this->created(new CorpMembershipResource($membership->load(['user.roles'])), 'Member added successfully');
    }

    /**
     * Deactivate a member.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $membership = CorpMembership::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->membershipService->deactivateMember($membership);

        return $this->success(message: 'Member deactivated successfully');
    }
}
