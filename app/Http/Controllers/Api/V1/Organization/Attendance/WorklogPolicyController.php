<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\UpdateWorklogPolicyRequest;
use App\Http\Resources\Attendance\WorklogPolicyResource;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendancePolicyService;
use App\Services\Attendance\WorklogPolicyService;
use Illuminate\Http\JsonResponse;

class WorklogPolicyController extends BaseApiController
{
    public function __construct(
        private readonly AttendancePolicyService $policyService,
        private readonly WorklogPolicyService $worklogPolicyService
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * Get the worklog compliance policy.
     */
    public function show(): JsonResponse
    {
        $policy = $this->policyService->findPolicy($this->getOrganization());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), auth()->user());
        }

        $worklogPolicy = $this->worklogPolicyService->getOrCreateWorklogPolicy($policy);

        return $this->success(new WorklogPolicyResource($worklogPolicy));
    }

    /**
     * Update the worklog compliance policy.
     */
    public function update(UpdateWorklogPolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->findPolicy($this->getOrganization());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), auth()->user());
        }

        $worklogPolicy = $this->worklogPolicyService->updateWorklogPolicy($policy, $request->validated());

        return $this->success(
            new WorklogPolicyResource($worklogPolicy),
            'Attendance worklog policy updated successfully.'
        );
    }
}
