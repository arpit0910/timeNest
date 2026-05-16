<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a corporation-level JWT guard
 * with a valid corporation_id claim.
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 * Returns 403 Forbidden if the token's guard is not 'corp' or has no corporation context.
 */
class EnsureCorpAccess
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

        if (!$context->isCorp() || !$context->hasCorporationContext()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Corporation-level authorization required.',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 403);
        }

        return $next($request);
    }
}
