<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\AdjustmentRequest;
use App\Http\Resources\Attendance\AttendanceAdjustmentRequestResource;
use App\Models\Attendance\AttendanceAdjustmentRequest;
use App\Models\Attendance\AttendanceDay;
use App\Models\Corporation\Corporation;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceAdjustmentController extends BaseApiController
{
    public function __construct(
        private readonly AttendanceService $attendanceService,
    ) {}

    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * List adjustments.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        // Standard users see only their requests, admins see all for the corp
        // Let's filter for user in this basic implementation, or based on permissions.
        // We will list all adjustments where the attendance day belongs to this corporation.
        $adjustments = AttendanceAdjustmentRequest::whereHas('attendanceDay', function ($query) {
            $query->where('corporation_id', $this->tenant()->id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return $this->success(AttendanceAdjustmentRequestResource::collection($adjustments));
    }

    /**
     * Submit adjustment request.
     */
    public function store(AdjustmentRequest $request): JsonResponse
    {
        $user = auth()->user();
        
        $day = AttendanceDay::where('corporation_id', $this->tenant()->id)
            ->where('id', $request->input('attendance_day_id'))
            ->firstOrFail();

        $adjustment = $this->attendanceService->submitAdjustment($user, $day, $request->validated());

        return $this->created(
            new AttendanceAdjustmentRequestResource($adjustment),
            'Adjustment request submitted successfully.'
        );
    }

    /**
     * Approve adjustment (Admin/Manager).
     */
    public function approve(string $uuid): JsonResponse
    {
        $adjustment = AttendanceAdjustmentRequest::where('uuid', $uuid)
            ->whereHas('attendanceDay', function ($query) {
                $query->where('corporation_id', $this->tenant()->id);
            })
            ->firstOrFail();

        $approvedAdjustment = $this->attendanceService->approveAdjustment($adjustment, auth()->user());

        return $this->success(
            new AttendanceAdjustmentRequestResource($approvedAdjustment),
            'Adjustment request approved successfully.'
        );
    }

    /**
     * Reject adjustment (Admin/Manager).
     */
    public function reject(Request $request, string $uuid): JsonResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $adjustment = AttendanceAdjustmentRequest::where('uuid', $uuid)
            ->whereHas('attendanceDay', function ($query) {
                $query->where('corporation_id', $this->tenant()->id);
            })
            ->firstOrFail();

        $rejectedAdjustment = $this->attendanceService->rejectAdjustment($adjustment, auth()->user(), $request->input('reason'));

        return $this->success(
            new AttendanceAdjustmentRequestResource($rejectedAdjustment),
            'Adjustment request rejected successfully.'
        );
    }
}
