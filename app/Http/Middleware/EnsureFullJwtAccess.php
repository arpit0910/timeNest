<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Auth\FullAuthenticationRequiredException;
use App\Exceptions\Business\JwtContextMissingException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a full JWT (not temporary).
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - FullAuthenticationRequiredException (403)
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 */
class EnsureFullJwtAccess
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws FullAuthenticationRequiredException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! jwt_has_context()) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        if (jwt_is_temp()) {
            throw new FullAuthenticationRequiredException();
        }

        return $next($request);
    }
}
