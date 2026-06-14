<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\AttendanceHistoryRequest;
use App\Http\Requests\Attendance\ClockInRequest;
use App\Http\Requests\Attendance\ClockOutRequest;
use App\Http\Resources\Attendance\AttendanceDayResource;
use App\Http\Resources\Attendance\AttendanceSessionResource;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendanceClockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends BaseApiController
{
    public function __construct(
        private readonly AttendanceClockService $clockService,
    ) {}

    /**
     * Resolve the current tenant organization.
     *
     * @return Organization
     */
    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * Clock in the authenticated user.
     *
     * @param ClockInRequest $request
     * @return JsonResponse
     */
    public function clockIn(ClockInRequest $request): JsonResponse
    {
        $session = $this->clockService->clockIn(
            $this->getOrganization(),
            $request->user(),
            $request->validated()
        );

        return $this->success(
            new AttendanceSessionResource($session),
            'Clock-in recorded successfully.',
            201
        );
    }

    /**
     * Clock out the authenticated user.
     *
     * @param ClockOutRequest $request
     * @return JsonResponse
     */
    public function clockOut(ClockOutRequest $request): JsonResponse
    {
        $session = $this->clockService->clockOut(
            $this->getOrganization(),
            $request->user(),
            $request->validated()
        );

        return $this->success(
            new AttendanceSessionResource($session),
            'Clock-out recorded successfully.'
        );
    }

    /**
     * Get today's attendance for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function today(Request $request): JsonResponse
    {
        $day = $this->clockService->getTodayAttendance(
            $this->getOrganization(),
            $request->user()
        );

        if ($day === null) {
            return $this->success(null, 'No attendance record for today yet.');
        }

        return $this->success(new AttendanceDayResource($day));
    }

    /**
     * Get paginated attendance history for the authenticated user.
     *
     * @param AttendanceHistoryRequest $request
     * @return JsonResponse
     */
    public function history(AttendanceHistoryRequest $request): JsonResponse
    {
        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'attendance_status' => $request->input('status'),
            'per_page' => $request->input('per_page', 30),
        ];

        $days = $this->clockService->getAttendanceHistory(
            $this->getOrganization(),
            $request->user(),
            $filters
        );

        return $this->paginated(
            AttendanceDayResource::collection($days)
        );
    }
}
