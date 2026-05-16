<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use App\Models\Corporation\Corporation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the tenant (Corporation) context from the JWT claims.
 *
 * Responsibilities:
 * 1. Loads the Corporation model from the JWT's corporation_id
 * 2. Validates the corporation is active
 * 3. Binds the Corporation to the container as 'tenant.corporation'
 * 4. Sets the Spatie team ID for permission resolution
 *
 * Must be placed AFTER jwt.auth and corp.access in the middleware stack.
 * Replaces SetSpatieTeamId and all manual Corporation::findOrFail() calls in controllers.
 */
class ResolveTenantContext
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

        if (!$context->hasCorporationContext()) {
            return response()->json([
                'success' => false,
                'message' => 'No corporation context available.',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 403);
        }

        $corporation = Corporation::find($context->corporationId);

        if (!$corporation) {
            return response()->json([
                'success' => false,
                'message' => 'Corporation not found.',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 404);
        }

        if (!$corporation->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Corporation has been deactivated.',
                'data'    => null,
                'errors'  => null,
                'meta'    => null,
            ], 403);
        }

        // Bind to container for downstream access
        app()->instance('tenant.corporation', $corporation);
        app()->instance('current.corporation', $corporation);

        // Set Spatie team ID for permission resolution
        setPermissionsTeamId($corporation->id);

        return $next($request);
    }
}
