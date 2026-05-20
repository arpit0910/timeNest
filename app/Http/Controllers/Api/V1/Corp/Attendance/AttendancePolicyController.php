<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp\Attendance;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Attendance\UpdatePolicyRequest;
use App\Http\Resources\Attendance\AttendancePolicyResource;
use App\Models\Corporation\Corporation;
use App\Services\Attendance\AttendancePolicyService;
use Illuminate\Http\JsonResponse;

class AttendancePolicyController extends BaseApiController
{
    public function __construct(
        private readonly AttendancePolicyService $policyService,
    ) {}

    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * Get the active policy.
     */
    public function show(): JsonResponse
    {
        $policy = $this->policyService->getActivePolicy($this->tenant());

        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->tenant(), auth()->user());
        }

        return $this->success(new AttendancePolicyResource($policy));
    }

    /**
     * Update the active policy.
     */
    public function update(UpdatePolicyRequest $request): JsonResponse
    {
        $policy = $this->policyService->getActivePolicy($this->tenant());

        if (! $policy) {
            $policy = $this->policyService->createDefaultPolicy($this->tenant(), auth()->user());
        }

        $updatedPolicy = $this->policyService->updatePolicy($policy, $request->validated(), auth()->user());

        return $this->success(
            new AttendancePolicyResource($updatedPolicy),
            'Attendance policy updated successfully.'
        );
    }
}
