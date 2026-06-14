<?php

$file = __DIR__ . '/routes/api.php';
$content = file_get_contents($file);

// Strip out the broken replacement block
$goodContent = preg_replace('/(\s*\/\/ Leave Request Routes.*?\}\);\s*\n\s*\}\);\s*)/s', "\n});\n", $content);

$routes = <<<'PHP'
    // Leave Request Routes
    Route::prefix('leave-requests')
        ->middleware(['auth:api', 'verified', \App\Http\Middleware\EnsureOrganizationAccess::class])
        ->controller(\App\Http\Controllers\Api\V1\Organization\Leave\LeaveRequestController::class)
        ->group(function (): void {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/balances', 'balances');
            Route::get('/{uuid}', 'show');
            Route::post('/{uuid}/approve', 'approve');
            Route::post('/{uuid}/reject', 'reject');
            Route::post('/{uuid}/cancel', 'cancel');
        });
});
PHP;

$content = preg_replace('/\}\);[\n\r\s]*$/', $routes, $goodContent);
file_put_contents($file, $content);

echo "Fixed api.php\n";
