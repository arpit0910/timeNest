<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Business\InvalidCorporationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a corporation-level JWT guard
 * with a valid corporation_id claim.
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidCorporationContextException (403)
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 */
class EnsureCorpAccess
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidCorporationContextException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! jwt_has_context()) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = jwt_context();

        if (! $context->isCorp() || ! $context->hasCorporationContext()) {
            throw new InvalidCorporationContextException('Access denied. Corporation-level authorization required.');
        }

        return $next($request);
    }
}
