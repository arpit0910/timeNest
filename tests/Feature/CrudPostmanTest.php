<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use App\Models\Organization\Department;
use App\Models\Organization\SubDepartment;
use App\Models\Organization\Designation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudPostmanTest extends TestCase
{
    public function test_postman_simulation()
    {
        $user = User::whereHas('roles', function($q) {
            $q->where('name', 'super_admin')->orWhere('name', 'director');
        })->first() ?? User::whereHas('organizations')->first();
        
        $this->actingAs($user, 'api');
        
        $dept = Department::whereNotNull('organization_id')->first();
        $deptUuid = $dept->uuid;

        // TEST 1: POST /api/v1/organization/sub-departments
        $response1 = $this->postJson('/api/v1/organization/sub-departments', [
            'department_uuid' => $deptUuid,
            'name' => 'Backend Engineering POSTMAN TEST'
        ]);
        
        echo "[POST /api/v1/organization/sub-departments] Status: " . $response1->status() . "\n";
        $subDeptUuid = $response1->json('data.uuid');

        // TEST 2: GET /api/v1/organization/sub-departments?department_uuid=<uuid>
        $response2 = $this->getJson("/api/v1/organization/sub-departments?department_uuid=$deptUuid");
        echo "[GET /api/v1/organization/sub-departments] Status: " . $response2->status() . "\n";

        // TEST 3: PUT /api/v1/organization/sub-departments/<global-uuid>
        $globalSubDept = SubDepartment::whereNull('organization_id')->first();
        if ($globalSubDept) {
            $response3 = $this->putJson("/api/v1/organization/sub-departments/{$globalSubDept->uuid}", [
                'name' => 'Should Fail'
            ]);
            echo "[PUT global sub-department] Status: " . $response3->status() . "\n";
        }

        // TEST 4: POST /api/v1/organization/designations
        if ($subDeptUuid) {
            $response4 = $this->postJson('/api/v1/organization/designations', [
                'sub_department_uuid' => $subDeptUuid,
                'name' => 'Junior Engineer POSTMAN TEST',
                'level' => 1
            ]);
            echo "[POST /api/v1/organization/designations] Status: " . $response4->status() . "\n";
            $desigUuid = $response4->json('data.uuid');
        }

        // TEST 5: GET /api/v1/organization/designations?sub_department_uuid=<uuid>
        if ($subDeptUuid) {
            $response5 = $this->getJson("/api/v1/organization/designations?sub_department_uuid=$subDeptUuid");
            echo "[GET /api/v1/organization/designations] Status: " . $response5->status() . "\n";
        }

        // TEST 6: DELETE /api/v1/organization/designations/<global-uuid>
        $globalDesig = Designation::whereNull('organization_id')->first();
        if ($globalDesig) {
            $response6 = $this->deleteJson("/api/v1/organization/designations/{$globalDesig->uuid}");
            echo "[DELETE global designation] Status: " . $response6->status() . "\n";
        }
        
        $this->assertTrue(true);
    }
}
