<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\EmailNotVerifiedException;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the authenticated user has verified their email address.
 *
 * THROWS exceptions for centralized handling:
 * - EmailNotVerifiedException (403)
 */
class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @throws EmailNotVerifiedException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {
            throw new EmailNotVerifiedException();
        }

        return $next($request);
    }
}
