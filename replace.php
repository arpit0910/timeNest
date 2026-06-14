<?php
$content = file_get_contents('tests/Feature/Leave/LeaveRequestTest.php');
$content = preg_replace(
    '/actingAs\(\$this->([a-z]+)\)->(postJson|getJson)\(\"\/api\/v1\/organization\/\{\$this->organization->uuid\}\//',
    'actingAsTenant($this->$1, $this->organization)->$2("/api/v1/',
    $content
);
file_put_contents('tests/Feature/Leave/LeaveRequestTest.php', $content);
echo "Replaced.";
