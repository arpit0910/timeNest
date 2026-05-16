<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Corporation\CreateDepartmentRequest;
use App\Http\Resources\Corporation\DepartmentResource;
use App\Models\Corporation\Corporation;
use App\Models\Corporation\Department;
use App\Services\Corporation\DepartmentService;
use Illuminate\Http\JsonResponse;

/**
 * Corporation-scoped department management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → corp.access → tenant.resolve → permission:departments.*
 *
 * Tenant context: resolved via app('tenant.corporation') — set by ResolveTenantContext middleware.
 * This controller contains ZERO authorization or tenant extraction logic.
 */
class DepartmentController extends BaseApiController
{
    public function __construct(
        private readonly DepartmentService $departmentService,
    ) {}

    /**
     * Resolve the active corporation from the container.
     */
    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * List all departments for the active corporation.
     */
    public function index(): JsonResponse
    {
        $departments = Department::where('corporation_id', $this->tenant()->id)
            ->with(['branch', 'parentDepartment', 'headUser'])
            ->get();

        return $this->success(DepartmentResource::collection($departments));
    }

    /**
     * Create a new department.
     */
    public function store(CreateDepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->createDepartment($this->tenant(), $request->validated());

        return $this->created(new DepartmentResource($department), 'Department created successfully');
    }

    /**
     * Get a specific department.
     */
    public function show(string $uuid): JsonResponse
    {
        $department = Department::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new DepartmentResource($department));
    }

    /**
     * Update a department.
     */
    public function update(CreateDepartmentRequest $request, string $uuid): JsonResponse
    {
        $department = Department::where('corporation_id', $this->tenant()->id)
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
        $department = Department::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->departmentService->deleteDepartment($department);

        return $this->success(message: 'Department deleted successfully');
    }
}
