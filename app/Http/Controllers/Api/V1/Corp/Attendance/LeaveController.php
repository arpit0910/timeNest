<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\LeaveRequest;
use App\Http\Resources\Attendance\EmployeeLeaveResource;
use App\Models\Attendance\EmployeeLeave;
use App\Models\Corporation\Corporation;
use App\Services\Attendance\LeaveManagementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveController extends BaseApiController
{
    public function __construct(
        private readonly LeaveManagementService $leaveService,
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
     * Cancel leave.
     */
    public function cancel(Request $request, string $uuid): JsonResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $leave = EmployeeLeave::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $cancelledLeave = $this->leaveService->cancelLeave($leave, $request->input('reason'));

        return $this->success(
            new EmployeeLeaveResource($cancelledLeave),
            'Leave request cancelled successfully.'
        );
    }

    /**
     * Approve leave (Admin/Manager only).
     */
    public function approve(string $uuid): JsonResponse
    {
        // Permission check can be at route middleware, we'll do it or let route handle it
        $leave = EmployeeLeave::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $approvedLeave = $this->leaveService->approveLeave($leave, auth()->user());

        return $this->success(
            new EmployeeLeaveResource($approvedLeave),
            'Leave request approved successfully.'
        );
    }

    /**
     * Reject leave (Admin/Manager only).
     */
    public function reject(Request $request, string $uuid): JsonResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $leave = EmployeeLeave::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $rejectedLeave = $this->leaveService->rejectLeave($leave, auth()->user(), $request->input('reason'));

        return $this->success(
            new EmployeeLeaveResource($rejectedLeave),
            'Leave request rejected successfully.'
        );
    }
}
