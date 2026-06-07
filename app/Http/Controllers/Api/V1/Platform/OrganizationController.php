<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Platform;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Organization\CreateOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Organization\Organization;
use App\Services\Organization\OrganizationService;
use Illuminate\Http\JsonResponse;

/**
 * Platform-level organization management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → platform.access → permission:organizations.manage
 *
 * This controller contains ZERO authorization logic.
 */
class OrganizationController extends BaseApiController
{
    public function __construct(
        private readonly OrganizationService $organizationService,
    ) {}

    /**
     * List all organizations on the platform.
     */
    public function index(): JsonResponse
    {
        $organizations = Organization::with('owner')->paginate(50);
        return OrganizationResource::collection($organizations)->response();
    }

    /**
     * Provision a new organization.
     */
    public function store(CreateOrganizationRequest $request): JsonResponse
    {
        $organization = $this->organizationService->createOrganization(
            data: $request->validated(),
            creator: $request->user()
        );

        return $this->created(new OrganizationResource($organization), 'Organization provisioned successfully');
    }

    /**
     * View a specific organization's details.
     */
    public function show(string $uuid): JsonResponse
    {
        $organization = Organization::where('uuid', $uuid)->with('owner')->firstOrFail();
        return $this->success(new OrganizationResource($organization));
    }

    /**
     * Update a organization's configuration.
     */
    public function update(UpdateOrganizationRequest $request, string $uuid): JsonResponse
    {
        $organization = Organization::where('uuid', $uuid)->firstOrFail();

        $organization = $this->organizationService->updateOrganization($organization, $request->validated());

        return $this->success(new OrganizationResource($organization), 'Organization created successfully', 201);
    }
}
