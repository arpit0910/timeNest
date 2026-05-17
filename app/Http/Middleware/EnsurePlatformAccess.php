<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use App\Exceptions\Business\InvalidCorporationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use App\Exceptions\Business\MembershipInactiveException;
use App\Models\Membership\PlatformMembership;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a platform-level JWT guard.
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidCorporationContextException (403)
 * - MembershipInactiveException (403)
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 */
class EnsurePlatformAccess
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidCorporationContextException
     * @throws MembershipInactiveException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->bound(JwtContext::class)) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = app(JwtContext::class);

        if (! $context->isPlatform()) {
            throw new InvalidCorporationContextException('Access denied. Platform-level authorization required.');
        }

        $membership = PlatformMembership::active()
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $membership) {
            throw new MembershipInactiveException('Access denied');
        }

        // Set Spatie team to null for platform context (global permissions)
        setPermissionsTeamId(null);
        app()->instance('platform.membership', $membership);

        return $next($request);
    }
}
