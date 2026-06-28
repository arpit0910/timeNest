<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rbac\CreateRoleRequest;
use App\Http\Requests\Rbac\DeleteRoleRequest;
use App\Http\Requests\Rbac\SyncPermissionsRequest;
use App\Http\Requests\Rbac\UpdateRoleRequest;
use App\Http\Resources\Rbac\RoleResource;
use App\Services\Rbac\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $organizationId = app('tenant.organization')->id;

        $roles = $this->roleService->list(
            organizationId: $organizationId,
            perPage: (int) $request->query('per_page', 20),
        );

        return RoleResource::collection($roles);
    }

    public function show(string $uuid): RoleResource
    {
        $organizationId = app('tenant.organization')->id;

        $role = $this->roleService->findByUuid($uuid, $organizationId);

        return new RoleResource($role);
    }

    public function store(CreateRoleRequest $request): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $role = $this->roleService->create(
            $request->validated(),
            $organizationId,
        );

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateRoleRequest $request, string $uuid): RoleResource
    {
        $organizationId = app('tenant.organization')->id;

        $role = $this->roleService->findByUuid($uuid, $organizationId);

        $updated = $this->roleService->update($role, $request->validated(), $organizationId);

        return new RoleResource($updated);
    }

    public function destroy(DeleteRoleRequest $request, string $uuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $role = $this->roleService->findByUuid($uuid, $organizationId);

        $this->roleService->delete(
            role: $role,
            organizationId: $organizationId,
            fallbackRoleUuid: $request->validated('fallback_role_uuid'),
        );

        return response()->json(['message' => 'Role deleted successfully.']);
    }

    public function syncPermissions(SyncPermissionsRequest $request, string $uuid): RoleResource
    {
        $organizationId = app('tenant.organization')->id;
        $actor = auth()->user();

        $role = $this->roleService->findByUuid($uuid, $organizationId);

        // Determine if actor is a platform admin
        $isPlatformAdmin = $actor->hasAnyRole([
            'app_director',
            'app_super_admin',
        ]);

        $updated = $this->roleService->syncPermissions(
            role: $role,
            permissionNames: $request->validated('permissions'),
            actor: $actor,
            isPlatformAdmin: $isPlatformAdmin,
            organizationId: $organizationId,
        );

        return new RoleResource($updated);
    }

    public function permissions(): JsonResponse
    {
        $actor = auth()->user();

        $isPlatformAdmin = $actor->hasAnyRole([
            'app_director',
            'app_super_admin',
        ]);

        $permissions = $this->roleService->listPermissions($isPlatformAdmin);

        return response()->json(['data' => $permissions]);
    }
}
