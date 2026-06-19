<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\ApproveWorklogRequest;
use App\Http\Requests\Attendance\RejectWorklogRequest;
use App\Http\Requests\Attendance\SubmitWorklogRequest;
use App\Http\Resources\Attendance\WorklogResource;
use App\Models\Attendance\AttendanceDay;
use App\Services\Attendance\WorklogSubmissionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorklogController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected WorklogSubmissionService $worklogSubmissionService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $organization = app('tenant.organization');
        $viewer = auth()->user();

        $filters = $request->only([
            'attendance_day_id',
            'worklog_status',
            'start_date',
            'end_date',
            'per_page'
        ]);

        $paginator = $this->worklogSubmissionService->getWorklogs($organization, $viewer, $filters);

        return $this->success(
            data: WorklogResource::collection($paginator)->response()->getData(true),
            message: 'Worklogs retrieved successfully.'
        );
    }

    public function storeForDay(SubmitWorklogRequest $request, string $dayUuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $user = auth()->user();

        $day = AttendanceDay::where('uuid', $dayUuid)
            ->where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $worklog = $this->worklogSubmissionService->submitWorklog(
            $organization,
            $user,
            $day,
            $request->validated(),
            $user
        );

        return $this->created(
            data: new WorklogResource($worklog),
            message: 'Worklog submitted successfully.'
        );
    }

    public function show(string $uuid, Request $request): JsonResponse
    {
        $organization = app('tenant.organization');
        $viewer = auth()->user();

        $worklog = $this->worklogSubmissionService->getWorklog($uuid, $organization, $viewer);

        $this->authorize('view', $worklog);

        return $this->success(
            data: new WorklogResource($worklog),
            message: 'Worklog retrieved successfully.'
        );
    }

    public function approve(ApproveWorklogRequest $request, string $uuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $approver = auth()->user();

        $worklog = $this->worklogSubmissionService->getWorklog($uuid, $organization, $approver);

        $this->authorize('approve', $worklog);

        $approvedWorklog = $this->worklogSubmissionService->approveWorklog(
            $worklog,
            $approver,
            $request->validated('remarks')
        );

        $message = $approvedWorklog->hasFirstLevelApproval() && !$approvedWorklog->isApproved()
            ? 'First level approval recorded.'
            : 'Worklog approved successfully.';

        return $this->success(
            data: new WorklogResource($approvedWorklog),
            message: $message
        );
    }

    public function reject(RejectWorklogRequest $request, string $uuid): JsonResponse
    {
        $organization = app('tenant.organization');
        $rejector = auth()->user();

        $worklog = $this->worklogSubmissionService->getWorklog($uuid, $organization, $rejector);

        $this->authorize('approve', $worklog);

        $rejectedWorklog = $this->worklogSubmissionService->rejectWorklog(
            $worklog,
            $rejector,
            $request->validated('rejection_reason')
        );

        return $this->success(
            data: new WorklogResource($rejectedWorklog),
            message: 'Worklog rejected.'
        );
    }

    public function forDay(string $dayUuid, Request $request): JsonResponse
    {
        $organization = app('tenant.organization');
        $viewer = auth()->user();

        $day = AttendanceDay::where('uuid', $dayUuid)
            ->where('organization_id', $organization->id)
            ->firstOrFail();

        $worklogs = $this->worklogSubmissionService->getWorklogsForDay($day, $organization, $viewer);

        return $this->success(
            data: WorklogResource::collection($worklogs),
            message: 'Worklogs retrieved successfully.'
        );
    }
}
