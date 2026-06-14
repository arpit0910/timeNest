<?php

$dirs = [__DIR__ . '/app', __DIR__ . '/tests'];
$replacements = [
    'App\\Enums\\LeaveTypeEnum' => 'App\\Enums\\Leave\\LeaveType',
    'LeaveTypeEnum' => 'LeaveType',
];

function processDir($dir, $replacements) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
            if ($content !== $newContent) {
                file_put_contents($file->getPathname(), $newContent);
                echo 'Updated: ' . $file->getPathname() . PHP_EOL;
            }
        }
    }
}

foreach ($dirs as $dir) { processDir($dir, $replacements); }
