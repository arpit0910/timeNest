<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Leave;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\ApproveLeaveRequest;
use App\Http\Requests\Leave\CancelLeaveRequest;
use App\Http\Requests\Leave\RejectLeaveRequest;
use App\Http\Requests\Leave\SubmitLeaveRequest;
use App\Http\Resources\Leave\LeaveBalanceResource;
use App\Http\Resources\Leave\LeaveRequestResource;
use App\Models\Organization\Organization;
use App\Services\Leave\LeaveRequestService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function __construct(private LeaveRequestService $leaveRequestService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $organization = app('tenant.organization');
        $filters = $request->validate([
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'end_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
            'leave_status' => 'nullable|integer',
            'leave_type_id' => 'nullable|string|uuid',
            'user_id' => 'nullable|string|uuid',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $paginator = $this->leaveRequestService->getLeaveRequests($organization, $request->user(), $filters);

        return response()->json([
            'success' => true,
            'data' => LeaveRequestResource::collection($paginator)->response()->getData(true),
        ]);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $leave = $this->leaveRequestService->getLeaveRequest($uuid, $organization, $request->user());

        return response()->json([
            'success' => true,
            'data' => new LeaveRequestResource($leave),
        ]);
    }

    public function store(SubmitLeaveRequest $request): JsonResponse
    {
        $organization = app('tenant.organization');
        $leave = $this->leaveRequestService->submitLeave($organization, $request->user(), $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Leave request submitted successfully.',
            'data' => new LeaveRequestResource($leave),
        ], 201);
    }

    public function approve(ApproveLeaveRequest $request, string $uuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $leave = $this->leaveRequestService->getLeaveRequest($uuid, $organization, $request->user());
        $leave = $this->leaveRequestService->approveLeave($leave, $request->user(), $request->validated('remarks'));

        return response()->json([
            'success' => true,
            'message' => 'Leave request approved.',
            'data' => new LeaveRequestResource($leave),
        ]);
    }

    public function reject(RejectLeaveRequest $request, string $uuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $leave = $this->leaveRequestService->getLeaveRequest($uuid, $organization, $request->user());
        $leave = $this->leaveRequestService->rejectLeave($leave, $request->user(), $request->validated('rejection_reason'));

        return response()->json([
            'success' => true,
            'message' => 'Leave request rejected.',
            'data' => new LeaveRequestResource($leave),
        ]);
    }

    public function cancel(CancelLeaveRequest $request, string $uuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $leave = $this->leaveRequestService->getLeaveRequest($uuid, $organization, $request->user());
        $leave = $this->leaveRequestService->cancelLeave($leave, $request->user(), $request->validated('reason'));

        return response()->json([
            'success' => true,
            'message' => 'Leave request cancelled.',
            'data' => new LeaveRequestResource($leave),
        ]);
    }

    public function balances(Request $request): JsonResponse
    {
        $organization = app('tenant.organization');
        $year = (int) $request->query('year', Carbon::now()->year);
        $balances = $this->leaveRequestService->getLeaveBalance($organization, $request->user(), $year);

        return response()->json([
            'success' => true,
            'data' => LeaveBalanceResource::collection($balances),
        ]);
    }
}
