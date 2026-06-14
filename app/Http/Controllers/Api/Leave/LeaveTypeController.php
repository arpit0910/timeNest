<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Leave;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Leave\CreateLeaveTypeRequest;
use App\Http\Requests\Leave\UpdateLeaveTypeRequest;
use App\Http\Resources\Leave\LeaveTypeResource;
use App\Models\Organization\Organization;
use App\Services\Leave\LeavePolicyService;
use App\Services\Leave\LeaveTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveTypeController extends BaseApiController
{
    public function __construct(
        private readonly LeaveTypeService $leaveTypeService,
        private readonly LeavePolicyService $leavePolicyService,
    ) {}

    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all leave types for a policy.
     */
    public function index(string $policyUuid, Request $request): JsonResponse
    {
        $policy = $this->leavePolicyService->getPolicyByUuid($policyUuid, $this->getOrganization());
        $types = $this->leaveTypeService->getTypesForPolicy($policy);

        return $this->success(LeaveTypeResource::collection($types));
    }

    /**
     * Create a new leave type.
     */
    public function store(CreateLeaveTypeRequest $request, string $policyUuid): JsonResponse
    {
        $policy = $this->leavePolicyService->getPolicyByUuid($policyUuid, $this->getOrganization());
        
        $type = $this->leaveTypeService->createType(
            $policy,
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new LeaveTypeResource($type),
            'Leave type created successfully.',
            201
        );
    }

    /**
     * Show a leave type.
     */
    public function show(string $uuid, Request $request): JsonResponse
    {
        $type = $this->leaveTypeService->getTypeByUuid($uuid, $this->getOrganization());

        return $this->success(new LeaveTypeResource($type));
    }

    /**
     * Update a leave type.
     */
    public function update(UpdateLeaveTypeRequest $request, string $uuid): JsonResponse
    {
        $type = $this->leaveTypeService->getTypeByUuid($uuid, $this->getOrganization());

        $updatedType = $this->leaveTypeService->updateType(
            $type,
            $request->validated(),
            $request->user()
        );

        return $this->success(
            new LeaveTypeResource($updatedType),
            'Leave type updated successfully.'
        );
    }

    /**
     * Deactivate a leave type.
     */
    public function deactivate(string $uuid, Request $request): JsonResponse
    {
        $type = $this->leaveTypeService->getTypeByUuid($uuid, $this->getOrganization());

        $deactivatedType = $this->leaveTypeService->deactivateType(
            $type,
            $request->user()
        );

        return $this->success(
            new LeaveTypeResource($deactivatedType),
            'Leave type deactivated successfully.'
        );
    }

    /**
     * Delete a leave type.
     */
    public function destroy(string $uuid, Request $request): JsonResponse
    {
        $type = $this->leaveTypeService->getTypeByUuid($uuid, $this->getOrganization());

        $this->leaveTypeService->deleteType($type);

        return $this->success(null, 'Leave type deleted successfully.');
    }
}
