<?php

use App\Exceptions\PermissionResolutionException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tm.jwt.auth'        => \App\Http\Middleware\JwtAuthenticate::class,
            'platform.access'    => \App\Http\Middleware\EnsurePlatformAccess::class,
            'corp.access'        => \App\Http\Middleware\EnsureCorpAccess::class,
            'tenant.resolve'     => \App\Http\Middleware\ResolveTenantContext::class,
            'verified.email'     => \App\Http\Middleware\EnsureEmailVerified::class,
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Always return JSON for API requests
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return true; // API-only application
        });

        // Authentication failure → 401
        $exceptions->render(function (AuthenticationException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Unauthenticated',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 401);
        });

        // Validation failure → 422
        $exceptions->render(function (ValidationException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data'    => null,
                'errors'  => $e->errors(),
                'meta'    => null,
            ], 422);
        });

        // Model not found → 404
        $exceptions->render(function (ModelNotFoundException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 404);
        });

        // Rate limiting → 429
        $exceptions->render(function (ThrottleRequestsException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'data'    => null,
                'errors'  => null,
                'meta'    => ['retry_after' => $e->getHeaders()['Retry-After'] ?? null],
            ], 429)->withHeaders($e->getHeaders());
        });

        // Permission resolution failure → 500
        $exceptions->render(function (PermissionResolutionException $e, Request $request): JsonResponse {
            report($e); // Log full stack trace
            return response()->json([
                'success' => false,
                'message' => 'An internal error occurred',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 500);
        });

        // Spatie Permission failure → 403
        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 403);
        });

        // All other HTTP exceptions (includes our custom ones)
        $exceptions->render(function (HttpException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], $e->getStatusCode());
        });

    })->create();
