<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Platform;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Corporation\CreateCorporationRequest;
use App\Http\Requests\Corporation\UpdateCorporationRequest;
use App\Http\Resources\Corporation\CorporationResource;
use App\Models\Corporation\Corporation;
use App\Services\Corporation\CorporationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Platform-level corporation management.
 *
 * Authorization: enforced entirely at the route level via middleware.
 * - jwt.auth → platform.access → permission:corporations.manage
 *
 * This controller contains ZERO authorization logic.
 */
class CorporationController extends BaseApiController
{
    public function __construct(
        private readonly CorporationService $corporationService,
    ) {}

    /**
     * List all corporations on the platform.
     */
    public function index(): JsonResponse
    {
        $corporations = Corporation::with(['country'])->paginate(20);

        return $this->paginated(CorporationResource::collection($corporations));
    }

    /**
     * Provision a new corporation.
     */
    public function store(CreateCorporationRequest $request): JsonResponse
    {
        $corporation = $this->corporationService->createCorporation(
            data: $request->validated(),
            creator: $request->user()
        );

        return $this->created(new CorporationResource($corporation), 'Corporation provisioned successfully');
    }

    /**
     * View a specific corporation's details.
     */
    public function show(string $uuid): JsonResponse
    {
        $corporation = Corporation::where('uuid', $uuid)->firstOrFail();

        return $this->success(new CorporationResource($corporation));
    }

    /**
     * Update a corporation's configuration.
     */
    public function update(UpdateCorporationRequest $request, string $uuid): JsonResponse
    {
        $corporation = Corporation::where('uuid', $uuid)->firstOrFail();

        $corporation = $this->corporationService->updateCorporation($corporation, $request->validated());

        return $this->success(new CorporationResource($corporation), 'Corporation updated successfully');
    }
}
