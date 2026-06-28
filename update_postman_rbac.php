<?php
$file = 'docs/postman/TimeNest.postman_collection.json';
$data = json_decode(file_get_contents($file), true);

$rbacFolderIndex = -1;
foreach ($data['item'] as $i => $item) {
    if (isset($item['name']) && $item['name'] === 'RBAC') {
        $rbacFolderIndex = $i;
        break;
    }
}
if ($rbacFolderIndex === -1) {
    $data['item'][] = ['name' => 'RBAC', 'item' => []];
    $rbacFolderIndex = count($data['item']) - 1;
}

$orgRolesIndex = -1;
$platformRolesIndex = -1;

foreach ($data['item'][$rbacFolderIndex]['item'] as $i => $item) {
    if ($item['name'] === 'Org Roles') $orgRolesIndex = $i;
    if ($item['name'] === 'Platform Roles') $platformRolesIndex = $i;
}

if ($orgRolesIndex === -1) {
    $data['item'][$rbacFolderIndex]['item'][] = ['name' => 'Org Roles', 'item' => []];
    $orgRolesIndex = count($data['item'][$rbacFolderIndex]['item']) - 1;
}
if ($platformRolesIndex === -1) {
    $data['item'][$rbacFolderIndex]['item'][] = ['name' => 'Platform Roles', 'item' => []];
    $platformRolesIndex = count($data['item'][$rbacFolderIndex]['item']) - 1;
}

function req($name, $method, $path, $body = null) {
    $req = [
        'name' => $name,
        'request' => [
            'method' => $method,
            'header' => [
                ['key' => 'Authorization', 'value' => 'Bearer {{auth_token}}', 'type' => 'text'],
                ['key' => 'Accept', 'value' => 'application/json', 'type' => 'text']
            ],
            'url' => [
                'raw' => '{{base_url}}/' . implode('/', $path),
                'host' => ['{{base_url}}'],
                'path' => $path
            ]
        ],
        'response' => []
    ];
    if ($body) {
        $req['request']['header'][] = ['key' => 'Content-Type', 'value' => 'application/json', 'type' => 'text'];
        $req['request']['body'] = [
            'mode' => 'raw',
            'raw' => is_string($body) ? $body : json_encode($body, JSON_PRETTY_PRINT),
            'options' => ['raw' => ['language' => 'json']]
        ];
    }
    return $req;
}

// Org Roles
$orgReqs = [
    req('List Roles', 'GET', ['api', 'v1', 'roles']),
    req('View Single Role', 'GET', ['api', 'v1', 'roles', '{{role_uuid}}']),
    req('List Available Permissions', 'GET', ['api', 'v1', 'roles', 'permissions']),
    req('Create Custom Role', 'POST', ['api', 'v1', 'roles'], ["name" => "Custom Finance Reviewer", "sort_order" => 10]),
    req('Update Role', 'PUT', ['api', 'v1', 'roles', '{{role_uuid}}'], ["name" => "Updated Role Name"]),
    req('Sync Role Permissions', 'PUT', ['api', 'v1', 'roles', '{{role_uuid}}', 'permissions'], ["permissions" => ["roles.view", "users.view"]]),
    req('Delete Role', 'DELETE', ['api', 'v1', 'roles', '{{role_uuid}}'], ["fallback_role_uuid" => "{{fallback_role_uuid}}"])
];

// Platform Roles
$platReqs = [
    req('List All Roles (Platform)', 'GET', ['api', 'v1', 'platform', 'roles']),
    req('Create Global Role', 'POST', ['api', 'v1', 'platform', 'roles'], ["name" => "global_custom_role", "is_system_role" => false]),
    req('Sync Global Role Permissions', 'PUT', ['api', 'v1', 'platform', 'roles', '{{role_uuid}}', 'permissions'], ["permissions" => ["roles.view", "platform.roles.manage"]]),
    req('Delete Global Role (non-system)', 'DELETE', ['api', 'v1', 'platform', 'roles', '{{role_uuid}}'])
];

foreach (['orgReqs' => $orgRolesIndex, 'platReqs' => $platformRolesIndex] as $var => $idx) {
    foreach ($$var as $newReq) {
        $exists = false;
        foreach ($data['item'][$rbacFolderIndex]['item'][$idx]['item'] as $existing) {
            if ($existing['name'] === $newReq['name']) {
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $data['item'][$rbacFolderIndex]['item'][$idx]['item'][] = $newReq;
        }
    }
}

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Postman updated.\n";
