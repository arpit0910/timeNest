<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Corporation\CreateBranchRequest;
use App\Http\Resources\Corporation\BranchResource;
use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;
use App\Services\Corporation\BranchService;
use Illuminate\Http\JsonResponse;

/**
 * Corporation-scoped branch management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → corp.access → tenant.resolve → permission:branches.*
 *
 * Tenant context: resolved via app('tenant.corporation') — set by ResolveTenantContext middleware.
 * This controller contains ZERO authorization or tenant extraction logic.
 */
class BranchController extends BaseApiController
{
    public function __construct(
        private readonly BranchService $branchService,
    ) {}

    /**
     * Resolve the active corporation from the container.
     */
    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * List all branches for the active corporation.
     */
    public function index(): JsonResponse
    {
        $branches = Branch::where('corporation_id', $this->tenant()->id)
            ->with(['state', 'country'])
            ->get();

        return $this->success(BranchResource::collection($branches));
    }

    /**
     * Create a new branch.
     */
    public function store(CreateBranchRequest $request): JsonResponse
    {
        $branch = $this->branchService->createBranch($this->tenant(), $request->validated());

        return $this->created(new BranchResource($branch), 'Branch created successfully');
    }

    /**
     * Get a specific branch.
     */
    public function show(string $uuid): JsonResponse
    {
        $branch = Branch::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new BranchResource($branch));
    }

    /**
     * Update a branch.
     */
    public function update(CreateBranchRequest $request, string $uuid): JsonResponse
    {
        $branch = Branch::where('corporation_id', $this->tenant()->id)
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
        $branch = Branch::where('corporation_id', $this->tenant()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->branchService->deleteBranch($branch);

        return $this->success(message: 'Branch deleted successfully');
    }
}
