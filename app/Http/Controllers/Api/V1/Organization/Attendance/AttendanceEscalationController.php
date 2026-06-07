<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Actions\Attendance\ResolveAttendanceEscalationAction;
use App\Enums\EscalationStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\UpdateAttendanceEscalationStatusRequest;
use App\Http\Resources\Attendance\AttendanceEscalationResource;
use App\Models\Attendance\AttendanceEscalation;
use App\Models\Organization\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AttendanceEscalationController extends BaseApiController
{
    public function __construct(
        private readonly ResolveAttendanceEscalationAction $resolveAction
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all escalations.
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $organization = $this->getOrganization();
        setPermissionsTeamId($organization->id);

        try {
            $platformRole = resolve_platform_role($user);
            $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

            // Check if manager/admin permission exists
            $canViewAll = $isAppOwner || $user->hasPermissionTo('attendance_escalations_resolve');

            $query = AttendanceEscalation::where('organization_id', $organization->id);

            if (! $canViewAll) {
                $query->where('user_id', $user->id);
            }

            $escalations = $query->orderBy('created_at', 'desc')->get();

            return $this->success(AttendanceEscalationResource::collection($escalations));
        } finally {
            setPermissionsTeamId(null);
        }
    }

    /**
     * Show a single escalation.
     */
    public function show(string $uuid): JsonResponse
    {
        $escalation = AttendanceEscalation::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        $user = auth()->user();
        if ($escalation->user_id !== $user->id) {
            setPermissionsTeamId($this->getOrganization()->id);
            try {
                $platformRole = resolve_platform_role($user);
                $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

                if (! $isAppOwner && ! $user->hasPermissionTo('attendance_escalations_resolve')) {
                    throw new BusinessRuleViolationException('Access denied.', 'UNAUTHORIZED');
                }
            } finally {
                setPermissionsTeamId(null);
            }
        }

        return $this->success(new AttendanceEscalationResource($escalation));
    }

    /**
     * Update the status of an escalation.
     */
    public function updateStatus(UpdateAttendanceEscalationStatusRequest $request, string $uuid): JsonResponse
    {
        $user = auth()->user();
        setPermissionsTeamId($this->getOrganization()->id);

        try {
            $platformRole = resolve_platform_role($user);
            $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

            if (! $isAppOwner && ! $user->hasPermissionTo('attendance_escalations_resolve')) {
                throw new UnauthorizedException(403, 'You do not have permission to resolve escalations.');
            }
        } finally {
            setPermissionsTeamId(null);
        }

        $escalation = AttendanceEscalation::where('uuid', $uuid)
            ->where('organization_id', $this->getOrganization()->id)
            ->firstOrFail();

        if ($escalation->escalation_status !== EscalationStatusEnum::Pending) {
            throw new BusinessRuleViolationException('This escalation is already resolved or dismissed.', 'ESCALATION_ALREADY_FINALIZED');
        }

        $validated = $request->validated();
        $status = EscalationStatusEnum::from((int) $validated['status']);

        $dismiss = ($status === EscalationStatusEnum::Dismissed);

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
