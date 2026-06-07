<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\UpdatePolicyRequest;
use App\Http\Resources\Attendance\AttendancePolicyResource;
use App\Models\Organization\Organization;
use App\Services\Attendance\AttendancePolicyService;
use Illuminate\Http\JsonResponse;

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
     * Get the active policy.
     */
    public function show(): JsonResponse
    {
        $policy = $this->policyService->getActivePolicy($this->getOrganization());

        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), auth()->user());
        }

        return $this->success(new AttendancePolicyResource($policy));
    }

    /**
     * Update the active policy.
     */
    public function update(UpdatePolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->getActivePolicy($this->getOrganization());

        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->getOrganization(), auth()->user());
        }

        $updatedPolicy = $this->policyService->updatePolicy($policy, $request->validated(), auth()->user());

        $organization = $this->getOrganization();

        $policies = AttendancePolicy::where('organization_id', $organization->id)->get();

        return $this->success(
            new AttendancePolicyResource($updatedPolicy),
            'Attendance policy updated successfully.'
        );
    }
}
