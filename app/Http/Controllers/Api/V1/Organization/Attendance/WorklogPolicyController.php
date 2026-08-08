<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\UpdateWorklogPolicyRequest;
use App\Http\Resources\Attendance\WorklogPolicyResource;
use App\Http\Resources\Attendance\WorklogPolicyVersionResource;
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
        $user = auth()->user();
        $policy = $this->policyService->findPolicy($this->getOrganization());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), $user);
        }

        $worklogPolicy = $this->worklogPolicyService->getOrCreateWorklogPolicy($policy, $user);

        return $this->success(new WorklogPolicyResource($worklogPolicy));
    }

    /**
     * Update the worklog compliance policy.
     */
    public function update(UpdateWorklogPolicyRequest $request): JsonResponse
    {
        $user = auth()->user();
        $policy = $this->policyService->findPolicy($this->getOrganization());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), $user);
        }

        $worklogPolicy = $this->worklogPolicyService->updateWorklogPolicy($policy, $request->validated(), $user);

        return $this->success(
            new WorklogPolicyResource($worklogPolicy),
            'Attendance worklog policy updated successfully.'
        );
    }

    /**
     * Get versions of the worklog compliance policy.
     */
    public function versions(): JsonResponse
    {
        $user = auth()->user();
        $policy = $this->policyService->findPolicy($this->getOrganization());
        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), $user);
        }

        $worklogPolicy = $this->worklogPolicyService->getOrCreateWorklogPolicy($policy, $user);
        $versions = $this->worklogPolicyService->getPolicyVersions($worklogPolicy);
        $versions->load(['policy', 'createdBy']);

        return $this->success(WorklogPolicyVersionResource::collection($versions));
    }
}
