<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Actions\Attendance\ResolveAttendanceEscalationAction;
use App\Enums\EscalationStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\EscalationListRequest;
use App\Http\Requests\Attendance\UpdateAttendanceEscalationStatusRequest;
use App\Http\Resources\Attendance\AttendanceEscalationResource;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AttendanceEscalationController extends BaseApiController
{
    public function __construct(
        private readonly ResolveAttendanceEscalationAction $resolveAction,
        private readonly AttendanceService $attendanceService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all escalations.
     */
    public function index(EscalationListRequest $request): JsonResponse
    {
        $escalations = $this->attendanceService->getEscalations(
            auth()->user(),
            $this->getOrganization(),
            $request->validated()
        );

        return $this->success(AttendanceEscalationResource::collection($escalations));
    }

    /**
     * Show a single escalation.
     */
    public function show(string $uuid): JsonResponse
    {
        $escalation = AttendanceEscalation::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        $this->authorize('view', $escalation);

        return $this->success(new AttendanceEscalationResource($escalation));
    }

    /**
     * Update the status of an escalation.
     */
    public function updateStatus(UpdateAttendanceEscalationStatusRequest $request, string $uuid): JsonResponse
    {
        $escalation = AttendanceEscalation::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        $user = auth()->user();
        $this->authorize('resolve', $escalation);

        if ($escalation->escalation_status !== EscalationStatusEnum::PENDING) {
            throw new BusinessRuleViolationException('This escalation is already resolved or dismissed.', 'ESCALATION_ALREADY_FINALIZED');
        }

        $validated = $request->validated();
        $status = EscalationStatusEnum::from((int) $validated['status']);

        $dismiss = ($status === EscalationStatusEnum::DISMISSED);

        $updated = $this->resolveAction->execute(
            $escalation,
            $user,
            $dismiss,
            $validated['remarks'] ?? null
        );

        return $this->success(
            new AttendanceEscalationResource($updated),
            "Escalation status updated to {$status->label()} successfully."
        );
    }
}
