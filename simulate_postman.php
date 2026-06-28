<?php

use App\Models\Auth\User;
use App\Models\Organization\Department;
use App\Models\Organization\SubDepartment;
use App\Models\Organization\Designation;
use Illuminate\Http\Request;

echo "--- STARTING MANUAL API TESTS (Simulating Postman) ---\n\n";

// 1. Get an admin user and generate a JWT token
$user = User::whereHas('organizations')->first();

if (!$user) {
    echo "No admin user found. Aborting.\n";
    exit(1);
}
$token = auth('api')->login($user);

// Get a department uuid
$dept = Department::whereNotNull('organization_id')->first();
$deptUuid = $dept->uuid;

// Function to simulate request
function runRequest($method, $uri, $body, $user) {
    $token = auth('api')->login($user);
    $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    echo "[$method] $uri\n";
    $server = [
        'HTTP_AUTHORIZATION' => "Bearer $token",
        'HTTP_ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
    ];
    $req = Request::create($uri, $method, $body, [], [], $server, json_encode($body));
    $res = $kernel->handle($req);
    echo "Status: " . $res->getStatusCode() . "\n";
    echo "Response: " . substr($res->getContent(), 0, 500) . (strlen($res->getContent()) > 500 ? "..." : "") . "\n\n";
    return json_decode($res->getContent(), true);
}

// TEST 1: POST /api/v1/organization/sub-departments
$res1 = runRequest('POST', '/api/v1/organization/sub-departments', [
    'department_uuid' => $deptUuid,
    'name' => 'Backend Engineering POSTMAN TEST'
], $user);
$subDeptUuid = $res1['data']['uuid'] ?? null;

// TEST 2: GET /api/v1/organization/sub-departments?department_uuid=<uuid>
runRequest('GET', "/api/v1/organization/sub-departments?department_uuid=$deptUuid", [], $user);

// TEST 3: PUT /api/v1/organization/sub-departments/<global-uuid>
$globalSubDept = SubDepartment::whereNull('organization_id')->first();
if ($globalSubDept) {
    runRequest('PUT', "/api/v1/organization/sub-departments/{$globalSubDept->uuid}", [
        'name' => 'Should Fail'
    ], $user);
} else {
    echo "[PUT] No global sub-department found to test.\n\n";
}

// TEST 4: POST /api/v1/organization/designations
if ($subDeptUuid) {
    $res4 = runRequest('POST', '/api/v1/organization/designations', [
        'sub_department_uuid' => $subDeptUuid,
        'name' => 'Junior Engineer POSTMAN TEST',
        'level' => 1
    ], $user);
    $desigUuid = $res4['data']['uuid'] ?? null;
} else {
    echo "Failed to create sub_department, skipping designation tests.\n";
}

// TEST 5: GET /api/v1/organization/designations?sub_department_uuid=<uuid>
if ($subDeptUuid) {
    runRequest('GET', "/api/v1/organization/designations?sub_department_uuid=$subDeptUuid", [], $user);
}

// TEST 6: DELETE /api/v1/organization/designations/<global-uuid>
$globalDesig = Designation::whereNull('organization_id')->first();
if ($globalDesig) {
    runRequest('DELETE', "/api/v1/organization/designations/{$globalDesig->uuid}", [], $user);
} else {
    echo "[DELETE] No global designation found to test.\n\n";
}

echo "--- TESTS COMPLETE ---\n";
