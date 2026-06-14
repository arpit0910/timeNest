<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Worklog;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Worklog\CreateWorklogPolicyRequest;
use App\Http\Requests\Worklog\UpdateWorklogPolicyRequest;
use App\Http\Resources\Worklog\WorklogPolicyResource;
use App\Http\Resources\Worklog\WorklogPolicyVersionResource;
use App\Models\Organization\Organization;
use App\Services\Worklog\WorklogPolicyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorklogPolicyController extends BaseApiController
{
    public function __construct(
        private readonly WorklogPolicyService $policyService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * Get the current worklog policy for the organization.
     */
    public function index(Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicy($this->getOrganization());

        return $this->success(new WorklogPolicyResource($policy));
    }

    /**
     * Create a new worklog policy.
     */
    public function store(CreateWorklogPolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->createPolicy(
            $this->getOrganization(),
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new WorklogPolicyResource($policy),
            'Worklog policy created successfully.',
            201
        );
    }

    /**
     * Get a specific policy by UUID.
     */
    public function show(string $uuid, Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        return $this->success(new WorklogPolicyResource($policy));
    }

    /**
     * Update a worklog policy.
     */
    public function update(UpdateWorklogPolicyRequest $request, string $uuid): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        $updatedPolicy = $this->policyService->updatePolicy(
            $policy,
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new WorklogPolicyResource($updatedPolicy),
            'Worklog policy updated successfully.'
        );
    }

    /**
     * Get versions of a policy.
     */
    public function versions(string $uuid, Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        $versions = $this->policyService->getPolicyVersions($policy);
        $versions->load(['policy', 'createdBy']);

        return $this->success(WorklogPolicyVersionResource::collection($versions));
    }
}
