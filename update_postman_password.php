<?php
$collectionPath = __DIR__ . '/docs/postman/TimeNest.postman_collection.json';
$collection = json_decode(file_get_contents($collectionPath), true);

$authFolderIndex = null;
foreach ($collection['item'] as $index => $item) {
    if ($item['name'] === 'Auth') {
        $authFolderIndex = $index;
        break;
    }
}

if ($authFolderIndex !== null) {
    $authFolder = $collection['item'][$authFolderIndex];
    
    $passwordFolderIndex = null;
    if (isset($authFolder['item'])) {
        foreach ($authFolder['item'] as $index => $item) {
            if ($item['name'] === 'Password') {
                $passwordFolderIndex = $index;
                break;
            }
        }
    }
    
    if ($passwordFolderIndex === null) {
        if (!isset($authFolder['item'])) {
            $authFolder['item'] = [];
        }
        $authFolder['item'][] = [
            'name' => 'Password',
            'item' => []
        ];
        $passwordFolderIndex = count($authFolder['item']) - 1;
    }
    
    $passwordFolder = $authFolder['item'][$passwordFolderIndex];
    
    $forgotExists = false;
    $resetExists = false;
    
    foreach ($passwordFolder['item'] as $item) {
        if ($item['name'] === 'Forgot Password') $forgotExists = true;
        if ($item['name'] === 'Reset Password') $resetExists = true;
    }
    
    if (!$forgotExists) {
        $passwordFolder['item'][] = [
            'name' => 'Forgot Password',
            'request' => [
                'method' => 'POST',
                'header' => [
                    ['key' => 'Accept', 'value' => 'application/json'],
                    ['key' => 'Content-Type', 'value' => 'application/json']
                ],
                'body' => [
                    'mode' => 'raw',
                    'raw' => "{\n    \"email\": \"user@example.com\"\n}",
                    'options' => ['raw' => ['language' => 'json']]
                ],
                'url' => [
                    'raw' => '{{base_url}}/auth/forgot-password',
                    'host' => ['{{base_url}}'],
                    'path' => ['auth', 'forgot-password']
                ]
            ]
        ];
    }
    
    if (!$resetExists) {
        $passwordFolder['item'][] = [
            'name' => 'Reset Password',
            'request' => [
                'method' => 'POST',
                'header' => [
                    ['key' => 'Accept', 'value' => 'application/json'],
                    ['key' => 'Content-Type', 'value' => 'application/json']
                ],
                'body' => [
                    'mode' => 'raw',
                    'raw' => "{\n    \"email\": \"user@example.com\",\n    \"token\": \"<64-char-token-from-email>\",\n    \"password\": \"NewPassword123!\",\n    \"password_confirmation\": \"NewPassword123!\"\n}",
                    'options' => ['raw' => ['language' => 'json']]
                ],
                'url' => [
                    'raw' => '{{base_url}}/auth/reset-password',
                    'host' => ['{{base_url}}'],
                    'path' => ['auth', 'reset-password']
                ]
            ]
        ];
    }
    
    $authFolder['item'][$passwordFolderIndex] = $passwordFolder;
    $collection['item'][$authFolderIndex] = $authFolder;
    
    file_put_contents($collectionPath, json_encode($collection, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    echo "Postman collection updated successfully.\n";
} else {
    echo "Auth folder not found.\n";
}
