<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\CreateAttendancePolicyRequest;
use App\Http\Requests\Attendance\UpdateAttendancePolicyRequest;
use App\Http\Resources\Attendance\AttendancePolicyResource;
use App\Http\Resources\Attendance\AttendancePolicyVersionResource;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendancePolicyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendancePolicyController extends BaseApiController
{
    public function __construct(
        private readonly AttendancePolicyService $policyService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * Get the current attendance policy for the organization.
     */
    public function index(Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicy($this->getOrganization());

        return $this->success(new AttendancePolicyResource($policy));
    }

    /**
     * Create a new attendance policy.
     */
    public function store(CreateAttendancePolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->createPolicy(
            $this->getOrganization(),
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new AttendancePolicyResource($policy),
            'Attendance policy created successfully.',
            201
        );
    }

    /**
     * Get a specific policy by UUID.
     */
    public function show(string $uuid, Request $request): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        return $this->success(new AttendancePolicyResource($policy));
    }

    /**
     * Update an attendance policy.
     */
    public function update(UpdateAttendancePolicyRequest $request, string $uuid): JsonResponse
    {
        $policy = $this->policyService->getPolicyByUuid($uuid, $this->getOrganization());

        $updatedPolicy = $this->policyService->updatePolicy(
            $policy,
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new AttendancePolicyResource($updatedPolicy),
            'Attendance policy updated successfully.'
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

        return $this->success(AttendancePolicyVersionResource::collection($versions));
    }
}
