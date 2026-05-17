<?php

use App\Exceptions\PermissionResolutionException;
use App\Http\Middleware\EnsureCorpAccess;
use App\Http\Middleware\EnsureEmailVerified;
use App\Http\Middleware\EnsureFullJwtAccess;
use App\Http\Middleware\EnsurePlatformAccess;
use App\Http\Middleware\EnsureTempTokenPurpose;
use App\Http\Middleware\JwtAuthenticate;
use App\Http\Middleware\ResolveTenantContext;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
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
            'tm.jwt.auth' => JwtAuthenticate::class,
            'platform.access' => EnsurePlatformAccess::class,
            'corp.access' => EnsureCorpAccess::class,
            'tenant.resolve' => ResolveTenantContext::class,
            'jwt.full' => EnsureFullJwtAccess::class,
            'jwt.temp' => EnsureTempTokenPurpose::class,
            'verified.email' => EnsureEmailVerified::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
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
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 401);
        });

        // Validation failure → 422
        $exceptions->render(function (ValidationException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => null,
                'errors' => $e->errors(),
                'meta' => null,
            ], 422);
        });

        // Model not found → 404
        $exceptions->render(function (ModelNotFoundException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 404);
        });

        // Rate limiting → 429
        $exceptions->render(function (ThrottleRequestsException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'data' => null,
                'errors' => null,
                'meta' => ['retry_after' => $e->getHeaders()['Retry-After'] ?? null],
            ], 429)->withHeaders($e->getHeaders());
        });

        // Permission resolution failure → 500
        $exceptions->render(function (PermissionResolutionException $e, Request $request): JsonResponse {
            report($e); // Log full stack trace

            return response()->json([
                'success' => false,
                'message' => 'An internal error occurred',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 500);
        });

        // Spatie Permission failure → 403
        $exceptions->render(function (UnauthorizedException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 403);
        });

        // All other HTTP exceptions (includes our custom ones)
        $exceptions->render(function (HttpException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], $e->getStatusCode());
        });

    })->create();
