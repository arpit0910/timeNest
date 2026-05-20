<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\UpdateWorklogPolicyRequest;
use App\Http\Resources\Attendance\AttendanceWorklogPolicyResource;
use App\Models\Corporation\Corporation;
use App\Services\Attendance\AttendancePolicyService;
use App\Services\Attendance\AttendanceWorklogPolicyService;
use Illuminate\Http\JsonResponse;

class AttendanceWorklogPolicyController extends BaseApiController
{
    public function __construct(
        private readonly AttendancePolicyService $policyService,
        private readonly AttendanceWorklogPolicyService $worklogPolicyService
    ) {}

    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * Get the worklog compliance policy.
     */
    public function show(): JsonResponse
    {
        $policy = $this->policyService->getActivePolicy($this->tenant());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->tenant(), auth()->user());
        }

        $worklogPolicy = $this->worklogPolicyService->getOrCreateWorklogPolicy($policy);

        return $this->success(new AttendanceWorklogPolicyResource($worklogPolicy));
    }

    /**
     * Update the worklog compliance policy.
     */
    public function update(UpdateWorklogPolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->getActivePolicy($this->tenant());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->tenant(), auth()->user());
        }

        $worklogPolicy = $this->worklogPolicyService->updateWorklogPolicy($policy, $request->validated());

        return $this->success(
            new AttendanceWorklogPolicyResource($worklogPolicy),
            'Attendance worklog policy updated successfully.'
        );
    }
}
