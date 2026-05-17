<?php

declare(strict_types=1);

namespace App\Services\Corporation;

use App\Models\Corporation\Corporation;
use App\Models\Corporation\Department;
use App\Traits\HasAuditLog;

/**
 * Handles Department lifecycle within a Corporation.
 */
class DepartmentService
{
    use HasAuditLog;

    /**
     * Create a new department.
     */
    public function createDepartment(Corporation $corp, array $data): Department
    {
        app()->instance('current.corporation', $corp);

        $dept = Department::create([
            'corporation_id' => $corp->id,
            'branch_id' => $data['branch_id'] ?? null,
            'parent_department_id' => $data['parent_department_id'] ?? null,
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'head_user_id' => $data['head_user_id'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        $this->logAction('department.created', $dept, [], $dept->toArray());

        return $dept;
    }

    /**
     * Update an existing department.
     */
    public function updateDepartment(Department $dept, array $data): Department
    {
        app()->instance('current.corporation', $dept->corporation);

        $old = $dept->toArray();
        $dept->update($data);

        $this->logAction('department.updated', $dept, $old, $dept->toArray());

        return $dept;
    }

    /**
     * Delete (soft) a department.
     */
    public function deleteDepartment(Department $dept): void
    {
        app()->instance('current.corporation', $dept->corporation);

        // Note: In a real system, we'd need to handle sub-departments and employee assignments
        // before deleting.
        $dept->delete();
        $this->logAction('department.deleted', $dept);
    }
}
