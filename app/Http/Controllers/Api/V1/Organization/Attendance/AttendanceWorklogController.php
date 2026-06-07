<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Actions\Attendance\CreateAttendanceWorklogAction;
use App\Actions\Attendance\UpdateAttendanceWorklogAction;
use App\Actions\Attendance\UpdateAttendanceWorklogStatusAction;
use App\Enums\WorkflowStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\StoreAttendanceWorklogRequest;
use App\Http\Requests\Attendance\UpdateAttendanceWorklogRequest;
use App\Http\Requests\Attendance\UpdateAttendanceWorklogStatusRequest;
use App\Http\Resources\Attendance\AttendanceWorklogResource;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Organization\Organization;
use App\Models\Project\Project;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Services\Attendance\TaskConsumptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceWorklogController extends BaseApiController
{
    public function __construct(
        private readonly CreateAttendanceWorklogAction $createAction,
        private readonly UpdateAttendanceWorklogAction $updateAction,
        private readonly UpdateAttendanceWorklogStatusAction $updateStatusAction,
        private readonly TaskConsumptionService $consumptionService
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List worklogs for the current organization.
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        setPermissionsTeamId($this->getOrganization()->id);

        try {
            $platformRole = resolve_platform_role($user);
            $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

            // Check if manager or app owner
            $canViewAll = $isAppOwner || $user->hasPermissionTo('attendance_worklogs_update_status');

            $query = AttendanceWorklog::where('organization_id', $this->getOrganization()->id)
                ->with(['project', 'milestone', 'task', 'statusHistories']);

            if (! $canViewAll) {
                $query->where('user_id', $user->id);
            }

            if ($request->has('user_uuid') && $canViewAll) {
                $query->whereHas('user', fn($q) => $q->where('uuid', $request->input('user_uuid')));
            }

            $worklogs = $query->orderBy('created_at', 'desc')->get();

            return $this->success(AttendanceWorklogResource::collection($worklogs));
        } finally {
            setPermissionsTeamId(null);
        }
    }

    /**
     * Show a worklog by UUID.
     */
    public function show(string $uuid): JsonResponse
    {
        $worklog = AttendanceWorklog::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->with(['project', 'milestone', 'task', 'statusHistories'])
            ->firstOrFail();

        // Check authorization
        $user = auth()->user();
        if ($worklog->user_id !== $user->id) {
            setPermissionsTeamId($this->getOrganization()->id);
            try {
                $platformRole = resolve_platform_role($user);
                $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

                if (! $isAppOwner && ! $user->hasPermissionTo('attendance_worklogs_update_status')) {
                    throw new BusinessRuleViolationException('Access denied.', 'UNAUTHORIZED');
                }
            } finally {
                setPermissionsTeamId(null);
            }
        }

        return $this->success(new AttendanceWorklogResource($worklog));
    }

    /**
     * Store a new worklog.
     */
    public function store(StoreAttendanceWorklogRequest $request): JsonResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Resolve UUIDs to IDs
        $day = AttendanceDay::where('uuid', $validated['attendance_day_uuid'])->firstOrFail();

        $resolvedData = [];
        if (! empty($validated['attendance_session_uuid'])) {
            $session = AttendanceSession::where('uuid', $validated['attendance_session_uuid'])->firstOrFail();
            $resolvedData['attendance_session_id'] = $session->id;
        }

        if (! empty($validated['project_uuid'])) {
            $project = Project::where('uuid', $validated['project_uuid'])->firstOrFail();
            $resolvedData['project_id'] = $project->id;
        }

        if (! empty($validated['milestone_uuid'])) {
            $milestone = Milestone::where('uuid', $validated['milestone_uuid'])->firstOrFail();
            $resolvedData['milestone_id'] = $milestone->id;
        }

        if (! empty($validated['task_uuid'])) {
            $task = Task::where('uuid', $validated['task_uuid'])->firstOrFail();
            $resolvedData['task_id'] = $task->id;
        }

        $resolvedData = array_merge($validated, $resolvedData);

        $worklog = $this->createAction->execute($user, $day, $resolvedData);

        return $this->created(
            new AttendanceWorklogResource($worklog),
            'Worklog created successfully.'
        );
    }

    /**
     * Update an existing worklog.
     */
    public function update(UpdateAttendanceWorklogRequest $request, string $uuid): JsonResponse
    {
        $user = auth()->user();
        $worklog = AttendanceWorklog::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        if ($worklog->user_id !== $user->id) {
            throw new BusinessRuleViolationException('Cannot update someone else\'s worklog.', 'UNAUTHORIZED');
        }

        $validated = $request->validated();

        // Resolve UUIDs
        $resolvedData = [];
        if (array_key_exists('project_uuid', $validated)) {
            $resolvedData['project_id'] = $validated['project_uuid'] 
                ? Project::where('uuid', $validated['project_uuid'])->firstOrFail()->id 
                : null;
        }
        if (array_key_exists('milestone_uuid', $validated)) {
            $resolvedData['milestone_id'] = $validated['milestone_uuid'] 
                ? Milestone::where('uuid', $validated['milestone_uuid'])->firstOrFail()->id 
                : null;
        }
        if (array_key_exists('task_uuid', $validated)) {
            $resolvedData['task_id'] = $validated['task_uuid'] 
                ? Task::where('uuid', $validated['task_uuid'])->firstOrFail()->id 
                : null;
        }

        $resolvedData = array_merge($validated, $resolvedData);

        $updated = $this->updateAction->execute($worklog, $user, $resolvedData);

        return $this->success(
            new AttendanceWorklogResource($updated),
            'Worklog updated successfully.'
        );
    }

    /**
     * Transition status of a worklog.
     */
    public function updateStatus(UpdateAttendanceWorklogStatusRequest $request, string $uuid): JsonResponse
    {
        $user = auth()->user();
        $worklog = AttendanceWorklog::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        $validated = $request->validated();
        $targetStatus = WorkflowStatusEnum::from((int) $validated['status']);

        $updated = $this->updateStatusAction->execute(
            $worklog,
            $targetStatus,
            $user,
            $validated['remarks'] ?? null,
            $validated['metadata'] ?? []
        );

        return $this->success(
            new AttendanceWorklogResource($updated),
            "Worklog status transitioned to {$targetStatus->label()} successfully."
        );
    }

    /**
     * Delete a worklog.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $user = auth()->user();
        $worklog = AttendanceWorklog::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        if ($worklog->user_id !== $user->id) {
            throw new BusinessRuleViolationException('Cannot delete someone else\'s worklog.', 'UNAUTHORIZED');
        }

        if (in_array($worklog->worklog_status, [WorkflowStatusEnum::Approved, WorkflowStatusEnum::Locked], true)) {
            throw new BusinessRuleViolationException('Cannot delete a worklog that is already Approved or Locked.', 'WORKLOG_LOCKED');
        }

        // Clean up task consumption and delete worklog
        $this->consumptionService->deleteConsumption($worklog);
        $worklog->delete();

        return $this->success(null, 'Worklog deleted successfully.');
    }
}
