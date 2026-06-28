<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Platform;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\CreateGlobalRoleRequest;
use App\Http\Requests\Rbac\DeleteRoleRequest;
use App\Http\Requests\Rbac\SyncPermissionsRequest;
use App\Http\Requests\Rbac\UpdateRoleRequest;
use App\Http\Resources\Rbac\RoleResource;
use App\Services\Rbac\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlatformRoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $roles = $this->roleService->listAll(
            perPage: (int) $request->query('per_page', 20),
        );

        return RoleResource::collection($roles);
    }

    public function show(string $uuid): RoleResource
    {
        // No org scoping — platform admin sees everything
        $role = $this->roleService->findByUuid($uuid, null);

        return new RoleResource($role);
    }

    public function store(CreateGlobalRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->createGlobal($request->validated(), auth()->user());

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateRoleRequest $request, string $uuid): RoleResource
    {
        $role = $this->roleService->findByUuid($uuid, null);

        // Platform admin — no org restriction
        $updated = $this->roleService->update($role, $request->validated(), null);

        return new RoleResource($updated);
    }

    public function destroy(DeleteRoleRequest $request, string $uuid): JsonResponse
    {
        $role = $this->roleService->findByUuid($uuid, null);

        $this->roleService->delete(
            role: $role,
            organizationId: null,
            fallbackRoleUuid: $request->validated('fallback_role_uuid'),
        );

        return response()->json(['message' => 'Role deleted successfully.']);
    }

    public function syncPermissions(SyncPermissionsRequest $request, string $uuid): RoleResource
    {
        $role = $this->roleService->findByUuid($uuid, null);

        $updated = $this->roleService->syncPermissions(
            role: $role,
            permissionNames: $request->validated('permissions'),
            actor: auth()->user(),
            isPlatformAdmin: true, // exempt from escalation check
            organizationId: null,
        );

        return new RoleResource($updated);
    }
}
