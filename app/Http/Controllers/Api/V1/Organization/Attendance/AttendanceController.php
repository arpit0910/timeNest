<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\ClockInRequest;
use App\Http\Requests\Attendance\ClockOutRequest;
use App\Http\Resources\Attendance\AttendanceDayResource;
use App\Http\Resources\Attendance\AttendanceSessionResource;
use App\Models\Attendance\AttendanceDay;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\JsonResponse;

class AttendanceController extends BaseApiController
{
    public function __construct(
        private readonly AttendanceService $attendanceService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * Clock in.
     */
    public function clockIn(ClockInRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = array_merge($request->validated(), [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $session = $this->attendanceService->clockIn($user, $this->getOrganization(), $data);

        return $this->created(
            new AttendanceSessionResource($session),
            'Clocked in successfully.'
        );
    }

    /**
     * Clock out.
     */
    public function clockOut(ClockOutRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = array_merge($request->validated(), [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $session = $this->attendanceService->clockOut($user, $this->getOrganization(), $data);

        return $this->success(
            new AttendanceSessionResource($session),
            'Clocked out successfully.'
        );
    }

    /**
     * Get today's attendance summary and sessions.
     */
    public function today(): JsonResponse
    {
        $user = auth()->user();
        $organization = $this->getOrganization();
        $today = \Carbon\Carbon::today()->toDateString();

        $day = AttendanceDay::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->where('attendance_date', $today)
            ->with('attendanceSessions')
            ->first();

        if (! $day) {
            return $this->success(null, 'No clock-in record found for today.');
        }

        return $this->success(new AttendanceDayResource($day));
    }

    /**
     * Get attendance history for the user.
     */
    public function history(): JsonResponse
    {
        $user = auth()->user();

        $history = AttendanceDay::where('user_id', $user->id)
            ->where('organization_id', $this->getOrganization()->id)
            ->with('attendanceSessions')
            ->orderBy('attendance_date', 'desc')
            ->paginate(30);

        return $this->success(AttendanceDayResource::collection($history));
    }
}
