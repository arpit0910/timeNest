<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Leave;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Leave\CreateLeavePolicyRequest;
use App\Http\Requests\Leave\UpdateLeavePolicyRequest;
use App\Http\Resources\Leave\LeavePolicyResource;
use App\Http\Resources\Leave\LeavePolicyVersionResource;
use App\Models\Organization\Organization;
use App\Services\Leave\LeavePolicyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeavePolicyController extends BaseApiController
{
    public function __construct(
        private readonly LeavePolicyService $policyService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * Get the current leave policy for the organization.
     */
    public function index(Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicy($this->getOrganization());

        return $this->success(new LeavePolicyResource($policy));
    }

    /**
     * Create a new leave policy.
     */
    public function store(CreateLeavePolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->createPolicy(
            $this->getOrganization(),
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new LeavePolicyResource($policy),
            'Leave policy created successfully.',
            201
        );
    }

    /**
     * Get a specific policy by UUID.
     */
    public function show(string $uuid, Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        return $this->success(new LeavePolicyResource($policy));
    }

    /**
     * Update a leave policy.
     */
    public function update(UpdateLeavePolicyRequest $request, string $uuid): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        $updatedPolicy = $this->policyService->updatePolicy(
            $policy,
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new LeavePolicyResource($updatedPolicy),
            'Leave policy updated successfully.'
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

        return $this->success(LeavePolicyVersionResource::collection($versions));
    }
}
