<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\LeaveRequest;
use App\Http\Requests\Attendance\UpdateLeaveStatusRequest;
use App\Http\Resources\Attendance\EmployeeLeaveResource;
use App\Models\Leave\EmployeeLeave;
use App\Models\Organization\Organization;
use App\Services\Attendance\LeaveManagementService;
use App\Services\Attendance\LeaveStatusTransitionService;
use App\Enums\Leave\LeaveStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveController extends BaseApiController
{
    public function __construct(
        private readonly LeaveManagementService $leaveService,
        private readonly LeaveStatusTransitionService $transitionService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all leaves for the user.
     */
    public function index(): JsonResponse
    {
        $organization = $this->getOrganization();

        $leaves = EmployeeLeave::where('organization_id', $organization->id)
            ->where('user_id', auth()->id())
            ->orderBy('start_date', 'desc')
            ->get();

        return $this->success(EmployeeLeaveResource::collection($leaves));
    }

    /**
     * Apply for leave.
     */
    public function store(LeaveRequest $request): JsonResponse
    {
        $user = auth()->user();
        $leave = $this->leaveService->applyForLeave($user, $this->getOrganization(), $request->validated());

        return $this->created(
            new EmployeeLeaveResource($leave),
            'Leave request submitted successfully.'
        );
    }

    /**
     * Show leave details.
     */
    public function show(string $uuid): JsonResponse
    {
        $leave = EmployeeLeave::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new EmployeeLeaveResource($leave));
    }

    /**
     * Update leave status via state machine.
     */
    public function updateStatus(UpdateLeaveStatusRequest $request, string $uuid): JsonResponse
    {
        $leave = EmployeeLeave::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $updatedLeave = $this->transitionService->transition(
            leave: $leave,
            newStatus: LeaveStatus::from((int) $request->input('status')),
            actor: auth()->user(),
            remarks: $request->input('remarks'),
            metadata: $request->input('metadata')
        );

        return $this->success(
            new EmployeeLeaveResource($updatedLeave),
            'Leave status updated successfully.'
        );
    }
}
