<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\CreateDesignationRequest;
use App\Http\Requests\Organization\UpdateDesignationRequest;
use App\Http\Resources\Organization\DesignationResource;
use App\Models\Organization\Designation;
use App\Services\Organization\DesignationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DesignationController extends Controller
{
    public function __construct(
        private readonly DesignationService $designationService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $organizationId = app('tenant.organization')->id;

        $designations = $this->designationService->list(
            organizationId: $organizationId,
            subDepartmentUuid: $request->query('sub_department_uuid'),
            perPage: (int) $request->query('per_page', 20),
        );

        return DesignationResource::collection($designations);
    }

    public function show(string $uuid): DesignationResource
    {
        $organizationId = app('tenant.organization')->id;

        $designation = $this->designationService->findByUuid($uuid, $organizationId);

        return new DesignationResource($designation);
    }

    public function store(CreateDesignationRequest $request): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $designation = $this->designationService->create(
            $request->validated(),
            $organizationId
        );

        return (new DesignationResource($designation))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateDesignationRequest $request, string $uuid): DesignationResource
    {
        $organizationId = app('tenant.organization')->id;

        $designation = $this->designationService->findByUuid($uuid, $organizationId);

        $updated = $this->designationService->update($designation, $request->validated());

        return new DesignationResource($updated);
    }

    public function destroy(string $uuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $designation = $this->designationService->findByUuid($uuid, $organizationId);

        $this->designationService->delete($designation);

        return response()->json(['message' => 'Designation deleted successfully.']);
    }
}
