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
use Illuminate\Http\Request;

class BranchController extends BaseApiController
{
    public function __construct(
        private readonly BranchService $branchService,
    ) {}

    /**
     * List all branches for the active corporation.
     */
    public function index(Request $request): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');
        
        $branches = Branch::where('corporation_id', $corpId)
            ->with(['state', 'country'])
            ->get();

        return $this->success(BranchResource::collection($branches));
    }

    /**
     * Create a new branch.
     */
    public function store(CreateBranchRequest $request): JsonResponse
    {
        $corp = Corporation::findOrFail($request->input('jwt_corporation_id'));

        $branch = $this->branchService->createBranch($corp, $request->validated());

        return $this->created(new BranchResource($branch), 'Branch created successfully');
    }

    /**
     * Get a specific branch.
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $branch = Branch::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return $this->success(new BranchResource($branch));
    }

    /**
     * Update a branch.
     * Reuses CreateBranchRequest for simplicity, in a real app might use UpdateBranchRequest.
     */
    public function update(CreateBranchRequest $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $branch = Branch::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $branch = $this->branchService->updateBranch($branch, $request->validated());

        return $this->success(new BranchResource($branch), 'Branch updated successfully');
    }

    /**
     * Delete a branch.
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $corpId = $request->input('jwt_corporation_id');

        $branch = Branch::where('corporation_id', $corpId)
            ->where('uuid', $uuid)
            ->firstOrFail();

        $this->branchService->deleteBranch($branch);

        return $this->success(message: 'Branch deleted successfully');
    }
}
