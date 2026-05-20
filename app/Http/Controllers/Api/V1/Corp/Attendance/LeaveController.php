<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\LeaveRequest;
use App\Http\Requests\Attendance\UpdateLeaveStatusRequest;
use App\Http\Resources\Attendance\EmployeeLeaveResource;
use App\Models\Attendance\EmployeeLeave;
use App\Models\Corporation\Corporation;
use App\Services\Attendance\LeaveManagementService;
use App\Services\Attendance\LeaveStatusTransitionService;
use App\Enums\LeaveStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveController extends BaseApiController
{
    public function __construct(
        private readonly LeaveManagementService $leaveService,
        private readonly LeaveStatusTransitionService $transitionService,
    ) {}

    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * List all leaves for the user.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $leaves = EmployeeLeave::where('user_id', $user->id)
            ->where('corporation_id', $this->tenant()->id)
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
        $leave = $this->leaveService->applyForLeave($user, $this->tenant(), $request->validated());

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
        $leave = EmployeeLeave::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new EmployeeLeaveResource($leave));
    }

    /**
     * Update leave status via state machine.
     */
    public function updateStatus(UpdateLeaveStatusRequest $request, string $uuid): JsonResponse
    {
        $leave = EmployeeLeave::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $updatedLeave = $this->transitionService->transition(
            leave: $leave,
            newStatus: LeaveStatusEnum::from((int) $request->input('status')),
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
