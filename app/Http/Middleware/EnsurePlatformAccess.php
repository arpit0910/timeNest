<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a platform-level JWT guard.
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 * Returns 403 Forbidden if the token's guard is not 'platform'.
 */
class EnsurePlatformAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!app()->bound(JwtContext::class)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. JWT context missing.',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 401);
        }

        $context = app(JwtContext::class);

        if (!$context->isPlatform()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Platform-level authorization required.',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 403);
        }

        // Set Spatie team to null for platform context (global permissions)
        setPermissionsTeamId(null);

        return $next($request);
    }
}
