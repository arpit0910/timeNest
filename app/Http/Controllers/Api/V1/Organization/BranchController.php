<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Organization\CreateBranchRequest;
use App\Http\Resources\Organization\BranchResource;
use App\Models\Organization\Organization;
use App\Models\Organization\Branch;
use App\Services\Organization\BranchService;
use Illuminate\Http\JsonResponse;

/**
 * Organization-scoped branch management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → organization.access → tenant.resolve → permission:branches.*
 *
 * Tenant context: resolved via app('tenant.organization') — set by ResolveTenantContext middleware.
 * This controller contains ZERO authorization or tenant extraction logic.
 */
class BranchController extends BaseApiController
{
    public function __construct(
        private readonly BranchService $branchService,
    ) {}

    /**
     * Resolve the active organization from the container.
     */
    private function getOrganization(): Organization
    {
        return app('tenant.organization');
    }

    /**
     * List all branches for the active organization.
     */
    public function index(): JsonResponse
    {
        $organization = $this->getOrganization();

        $branches = Branch::where('organization_id', $organization->id)
            ->with(['state', 'country'])
            ->get();

        return $this->success(BranchResource::collection($branches));
    }

    /**
     * Create a new branch.
     */
    public function store(CreateBranchRequest $request): JsonResponse
    {
        $branch = $this->branchService->createBranch($this->getOrganization(), $request->validated());

        return $this->created(new BranchResource($branch), 'Branch created successfully');
    }

    /**
     * Get a specific branch.
     */
    public function show(string $uuid): JsonResponse
    {
        $branch = Branch::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new BranchResource($branch));
    }

    /**
     * Update a branch.
     */
    public function update(CreateBranchRequest $request, string $uuid): JsonResponse
    {
        $branch = Branch::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $branch = $this->branchService->updateBranch($branch, $request->validated());

        return $this->success(new BranchResource($branch), 'Branch updated successfully');
    }

    /**
     * Delete a branch.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $branch = Branch::where('organization_id', $this->getOrganization()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->branchService->deleteBranch($branch);

        return $this->success(message: 'Branch deleted successfully');
    }
}
