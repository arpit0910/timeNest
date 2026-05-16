<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Corporation\AddMemberRequest;
use App\Http\Resources\Corporation\CorpMembershipResource;
use App\Models\Auth\User;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use App\Models\Rbac\Role;
use App\Services\Corporation\MembershipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipController extends BaseApiController
{
    public function __construct(
        private readonly MembershipService $membershipService,
    ) {}

    /**
     * List all members of the active corporation.
     */
    public function index(Request $request): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');
        
        $memberships = CorpMembership::where('corporation_id', $corpId)
            ->with(['user.roles'])
            ->paginate(50);

        return $this->success(CorpMembershipResource::collection($memberships)->response()->getData(true));
    }

    /**
     * Directly add a user to the corporation.
     */
    public function store(AddMemberRequest $request): JsonResponse
    {
        $corp = Corporation::findOrFail($request->input('jwt_corporation_id'));
        $user = User::findOrFail($request->input('user_id'));
        $role = Role::findOrFail($request->input('role_id'));

        // Prevent adding a user who is already a member
        if (CorpMembership::where('corporation_id', $corp->id)->where('user_id', $user->id)->exists()) {
            return $this->error('User is already a member of this corporation', status: 409);
        }

        $membership = $this->membershipService->addMember(
            corp: $corp,
            user: $user,
            role: $role,
            employeeData: $request->only([
                'employee_code', 'designation', 'department_id', 'branch_id',
                'employment_type', 'joining_date', 'reports_to'
            ]),
            invitedById: $request->user()->id
        );

        return $this->created(new CorpMembershipResource($membership->load(['user.roles'])), 'Member added successfully');
    }

    /**
     * Deactivate a member.
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $membership = CorpMembership::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->membershipService->deactivateMember($membership);

        return $this->success(message: 'Member deactivated successfully');
    }
}
