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

class CorporationController extends BaseApiController
{
    public function __construct(
        private readonly CorporationService $corporationService,
    ) {}

    /**
     * List all corporations on the platform (Platform Admin only).
     */
    public function index(Request $request): JsonResponse
    {
        // Enforce platform guard
        if ($request->input('jwt_guard') !== 'platform') {
            return $this->forbidden('Only platform administrators can perform this action.');
        }

        $corporations = Corporation::with(['country'])->paginate(20);

        return $this->success(CorporationResource::collection($corporations)->response()->getData(true));
    }

    /**
     * Provision a new corporation (Platform Admin only).
     */
    public function store(CreateCorporationRequest $request): JsonResponse
    {
        if ($request->input('jwt_guard') !== 'platform') {
            return $this->forbidden('Only platform administrators can perform this action.');
        }

        $corporation = $this->corporationService->createCorporation(
            data: $request->validated(),
            creator: $request->user()
        );

        return $this->created(new CorporationResource($corporation), 'Corporation provisioned successfully');
    }

    /**
     * View a specific corporation's details.
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        if ($request->input('jwt_guard') !== 'platform') {
            return $this->forbidden('Only platform administrators can perform this action.');
        }

        $corporation = Corporation::where('uuid', $uuid)->firstOrFail();

        return $this->success(new CorporationResource($corporation));
    }

    /**
     * Update a corporation's configuration.
     */
    public function update(UpdateCorporationRequest $request, string $uuid): JsonResponse
    {
        if ($request->input('jwt_guard') !== 'platform') {
            return $this->forbidden('Only platform administrators can perform this action.');
        }

        $corporation = Corporation::where('uuid', $uuid)->firstOrFail();

        $corporation = $this->corporationService->updateCorporation($corporation, $request->validated());

        return $this->success(new CorporationResource($corporation), 'Corporation updated successfully');
    }
}
