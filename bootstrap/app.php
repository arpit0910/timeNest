<?php

use App\Exceptions\BaseApiException;
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
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException as JwtTokenExpired;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException as JwtTokenInvalid;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
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

        $middleware->group('api.corp', [
            'tm.jwt.auth',
            'jwt.full',
            'corp.access',
            'tenant.resolve',
            'throttle:corp',
        ]);

        $middleware->group('api.platform', [
            'tm.jwt.auth',
            'jwt.full',
            'platform.access',
            'throttle:platform',
        ]);

        $middleware->group('api.temp', [
            'tm.jwt.auth',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // ALWAYS render JSON for this API-first application
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return $request->is('api/*') || $request->expectsJson();
        });

        // ========== CUSTOM DOMAIN EXCEPTIONS (BaseApiException) ==========
        // All custom business exceptions extend BaseApiException and are renderable
        $exceptions->render(function (BaseApiException $e, Request $request): JsonResponse {
            // Log if exception wants to be logged
            if ($e->shouldLog()) {
                report($e);
            }

            return $e->render();
        });

        // ========== VALIDATION FAILURES (422) ==========
        $exceptions->render(function (ValidationException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => null,
                'errors' => $e->errors(),
                'meta' => null,
            ], 422);
        });

        // ========== JWT EXCEPTIONS ==========
        // JWT library throws its own exceptions — map them to our pipeline
        $exceptions->render(function (JwtTokenExpired $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 401);
        });

        $exceptions->render(function (JwtTokenInvalid $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 401);
        });

        $exceptions->render(function (JWTException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 401);
        });

        // ========== AUTHENTICATION FAILURES (401) ==========
        $exceptions->render(function (AuthenticationException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Unauthenticated',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 401);
        });

        // ========== LARAVEL AUTHORIZATION (403) ==========
        $exceptions->render(function (UnauthorizedException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Access denied',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 403);
        });

        // ========== MODEL NOT FOUND (404) ==========
        $exceptions->render(function (ModelNotFoundException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 404);
        });

        // ========== RATE LIMITING (429) ==========
        $exceptions->render(function (ThrottleRequestsException $e, Request $request): JsonResponse {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? null;

            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'data' => null,
                'errors' => null,
                'meta' => $retryAfter ? ['retry_after' => $retryAfter] : null,
            ], 429)->withHeaders($e->getHeaders());
        });

        // ========== PERMISSION RESOLUTION FAILURE (500) ==========
        $exceptions->render(function (PermissionResolutionException $e, Request $request): JsonResponse {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'An internal error occurred',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 500);
        });

        // ========== DATABASE EXCEPTIONS (409/500) ==========
        // Catches: UNIQUE constraint violations, FOREIGN KEY violations, etc.
        $exceptions->render(function (QueryException $e, Request $request): JsonResponse {
            report($e);

            // Determine if it's a constraint violation (409) or other DB error (500)
            $statusCode = 500;
            $message = 'Database operation failed';

            // Check for common constraint violations
            if ($e->getCode() === '23505' || // UNIQUE constraint
                $e->getCode() === '23503' || // FOREIGN KEY
                $e->getCode() === '23502' || // NOT NULL
                strpos($e->getMessage(), 'unique') !== false ||
                strpos($e->getMessage(), 'foreign key') !== false ||
                strpos($e->getMessage(), 'UNIQUE') !== false) {

                $statusCode = 409;
                $message = 'Operation violates data constraints';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], $statusCode);
        });

        // ========== HTTP EXCEPTIONS (NotFound, MethodNotAllowed, etc.) ==========
        $exceptions->render(function (NotFoundHttpException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'Route not found',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 404);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => 'HTTP method not allowed',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], 405);
        });

        // Generic HTTP Exception (catches all other HttpException instances)
        $exceptions->render(function (HttpException $e, Request $request): JsonResponse {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred',
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], $e->getStatusCode());
        });

        // ========== GLOBAL FALLBACK — CATCH ANY THROWABLE (FINAL SAFETY NET) ==========
        // This ensures NO unexpected exceptions leak to the frontend
        $exceptions->render(function (Throwable $e, Request $request): JsonResponse {
            // Log the unexpected exception
            report($e);

            // Determine if we're in debug/local mode
            $isDebug = config('app.debug') === true;

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'data' => null,
                'errors' => null,
                'meta' => $isDebug ? [
                    'exception' => class_basename($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ] : null,
            ], 500);
        });

    })->create();
