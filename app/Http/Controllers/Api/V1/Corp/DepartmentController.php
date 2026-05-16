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
use Illuminate\Http\Request;

class DepartmentController extends BaseApiController
{
    public function __construct(
        private readonly DepartmentService $departmentService,
    ) {}

    /**
     * List all departments for the active corporation.
     */
    public function index(Request $request): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');
        
        $departments = Department::where('corporation_id', $corpId)
            ->with(['branch', 'parentDepartment', 'headUser'])
            ->get();

        return $this->success(DepartmentResource::collection($departments));
    }

    /**
     * Create a new department.
     */
    public function store(CreateDepartmentRequest $request): JsonResponse
    {
        $corp = Corporation::findOrFail($request->input('jwt_corporation_id'));

        $department = $this->departmentService->createDepartment($corp, $request->validated());

        return $this->created(new DepartmentResource($department), 'Department created successfully');
    }

    /**
     * Get a specific department.
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $department = Department::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new DepartmentResource($department));
    }

    /**
     * Update a department.
     */
    public function update(CreateDepartmentRequest $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $department = Department::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $department = $this->departmentService->updateDepartment($department, $request->validated());

        return $this->success(new DepartmentResource($department), 'Department updated successfully');
    }

    /**
     * Delete a department.
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $department = Department::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->departmentService->deleteDepartment($department);

        return $this->success(message: 'Department deleted successfully');
    }
}
