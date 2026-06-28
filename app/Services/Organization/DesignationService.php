<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Models\Organization\Designation;
use App\Models\Organization\SubDepartment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DesignationService
{
    public function list(int $organizationId, ?string $subDepartmentUuid, int $perPage = 20): LengthAwarePaginator
    {
        return Designation::with(['subDepartment.department'])
            ->forOrganization($organizationId)
            ->when($subDepartmentUuid, function ($query) use ($subDepartmentUuid) {
                $query->whereHas('subDepartment', fn($q) => $q->where('uuid', $subDepartmentUuid));
            })
            ->orderBy('sub_department_id')
            ->orderBy('level')
            ->paginate($perPage);
    }

    public function findByUuid(string $uuid, int $organizationId): Designation
    {
        return Designation::with(['subDepartment.department'])
            ->forOrganization($organizationId)
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function create(array $data, ?int $organizationId): Designation
    {
        // Org users cannot create global records
        if ($organizationId === null) {
            throw new \InvalidArgumentException('organization_id is required for creating designations.');
        }

        return DB::transaction(function () use ($data, $organizationId): Designation {
            $subDepartment = SubDepartment::where('uuid', $data['sub_department_uuid'])
                ->firstOrFail();

            return Designation::create([
                'organization_id'   => $organizationId,
                'sub_department_id' => $subDepartment->id,
                'name'              => $data['name'],
                'slug'              => Str::slug($data['name']),
                'description'       => $data['description'] ?? null,
                'level'             => $data['level'],
                'is_active'         => $data['is_active'] ?? true,
            ]);
        });
    }

    public function update(Designation $designation, array $data): Designation
    {
        if ($designation->organization_id === null) {
            throw new \RuntimeException('Global designations cannot be modified by organizations.');
        }

        return DB::transaction(function () use ($designation, $data): Designation {
            $designation->update([
                'name'        => $data['name'] ?? $designation->name,
                'slug'        => isset($data['name']) ? Str::slug($data['name']) : $designation->slug,
                'description' => $data['description'] ?? $designation->description,
                'level'       => $data['level'] ?? $designation->level,
                'is_active'   => $data['is_active'] ?? $designation->is_active,
            ]);

            return $designation->refresh();
        });
    }

    public function delete(Designation $designation): void
    {
        if ($designation->organization_id === null) {
            throw new \RuntimeException('Global designations cannot be deleted by organizations.');
        }

        DB::transaction(function () use ($designation): void {
            $designation->delete();
        });
    }
}
