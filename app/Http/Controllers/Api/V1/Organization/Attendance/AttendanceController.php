<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\AttendanceHistoryRequest;
use App\Http\Requests\Attendance\AttendanceTodayRequest;
use App\Http\Requests\Attendance\ClockInRequest;
use App\Http\Requests\Attendance\ClockOutRequest;
use App\Http\Resources\Attendance\AttendanceDayResource;
use App\Http\Resources\Attendance\AttendanceSessionResource;
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
        $validated = $request->validated();
        $data = [
            'source' => $validated['clock_in_source'],
            'device_id' => $validated['clock_in_device_id'] ?? null,
            'latitude' => $validated['clock_in_latitude'],
            'longitude' => $validated['clock_in_longitude'],
            'accuracy' => $validated['clock_in_accuracy'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

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
        $validated = $request->validated();
        $data = [
            'source' => $validated['clock_out_source'],
            'device_id' => $validated['clock_out_device_id'] ?? null,
            'latitude' => $validated['clock_out_latitude'],
            'longitude' => $validated['clock_out_longitude'],
            'accuracy' => $validated['clock_out_accuracy'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        $session = $this->attendanceService->clockOut($user, $this->getOrganization(), $data);

        return $this->success(
            new AttendanceSessionResource($session),
            'Clocked out successfully.'
        );
    }

    /**
     * Get today's attendance summary and sessions.
     */
    public function today(AttendanceTodayRequest $request): JsonResponse
    {
        $user = auth()->user();
        $day = $this->attendanceService->getToday(
            $user,
            $this->getOrganization(),
            $request->input('user_uuid')
        );

        if (! $day) {
            return $this->success(null, 'No clock-in record found for today.');
        }

        return $this->success(new AttendanceDayResource($day));
    }

    /**
     * Get attendance history for the user or team member.
     */
    public function history(AttendanceHistoryRequest $request): JsonResponse
    {
        $history = $this->attendanceService->getHistory(
            auth()->user(),
            $this->getOrganization(),
            $request->validated()
        );

        return $this->success(AttendanceDayResource::collection($history));
    }
}
