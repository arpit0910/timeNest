<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\CreateSubDepartmentRequest;
use App\Http\Requests\Organization\UpdateSubDepartmentRequest;
use App\Http\Resources\Organization\SubDepartmentResource;
use App\Models\Organization\SubDepartment;
use App\Services\Organization\SubDepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubDepartmentController extends Controller
{
    public function __construct(
        private readonly SubDepartmentService $subDepartmentService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $organizationId = app('tenant.organization')->id;

        $subDepartments = $this->subDepartmentService->list(
            organizationId: $organizationId,
            departmentUuid: $request->query('department_uuid'),
            perPage: (int) $request->query('per_page', 20),
        );

        return SubDepartmentResource::collection($subDepartments);
    }

    public function show(string $uuid): SubDepartmentResource
    {
        $organizationId = app('tenant.organization')->id;

        $subDepartment = $this->subDepartmentService->findByUuid($uuid, $organizationId);

        return new SubDepartmentResource($subDepartment);
    }

    public function store(CreateSubDepartmentRequest $request): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $subDepartment = $this->subDepartmentService->create(
            $request->validated(),
            $organizationId
        );

        return (new SubDepartmentResource($subDepartment))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateSubDepartmentRequest $request, string $uuid): SubDepartmentResource
    {
        $organizationId = app('tenant.organization')->id;

        $subDepartment = $this->subDepartmentService->findByUuid($uuid, $organizationId);

        $updated = $this->subDepartmentService->update($subDepartment, $request->validated(), $organizationId);

        return new SubDepartmentResource($updated);
    }

    public function destroy(string $uuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $subDepartment = $this->subDepartmentService->findByUuid($uuid, $organizationId);

        $this->subDepartmentService->delete($subDepartment);

        return response()->json(['message' => 'Sub-department deleted successfully.']);
    }
}
