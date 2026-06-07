<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Organization\CreateDepartmentRequest;
use App\Http\Resources\Organization\DepartmentResource;
use App\Models\Organization\Organization;
use App\Models\Organization\Department;
use App\Services\Organization\DepartmentService;
use Illuminate\Http\JsonResponse;

/**
 * Organization-scoped department management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → organization.access → tenant.resolve → permission:departments.*
 *
 * Tenant context: resolved via app('tenant.organization') — set by ResolveTenantContext middleware.
 * This controller contains ZERO authorization or tenant extraction logic.
 */
class DepartmentController extends BaseApiController
{
    public function __construct(
        private readonly DepartmentService $departmentService,
    ) {}

    /**
     * Resolve the active organization from the container.
     */
    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all departments for the active organization.
     */
    public function index(): JsonResponse
    {
        $organization = $this->getOrganization();

        $departments = Department::where('organization_id', $organization->id)
            ->with(['branch', 'parent', 'head'])
            ->get();

        return $this->success(DepartmentResource::collection($departments));
    }

    /**
     * Create a new department.
     */
    public function store(CreateDepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->createDepartment($this->getOrganization(), $request->validated());

        return $this->created(new DepartmentResource($department), 'Department created successfully');
    }

    /**
     * Get a specific department.
     */
    public function show(string $uuid): JsonResponse
    {
        $department = Department::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new DepartmentResource($department));
    }

    /**
     * Update a department.
     */
    public function update(CreateDepartmentRequest $request, string $uuid): JsonResponse
    {
        $department = Department::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $department = $this->departmentService->updateDepartment($department, $request->validated());

        return $this->success(new DepartmentResource($department), 'Department updated successfully');
    }

    /**
     * Delete a department.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $department = Department::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->departmentService->deleteDepartment($department);

        return $this->success(message: 'Department deleted successfully');
    }
}
