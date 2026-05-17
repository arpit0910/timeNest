<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Auth\EmailNotVerifiedException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the authenticated user has verified their email address.
 *
 * THROWS exceptions for centralized handling:
 * - EmailNotVerifiedException (403)
 */
class EnsureEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @throws EmailNotVerifiedException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->email_verified_at) {
            throw new EmailNotVerifiedException();
        }

        return $next($request);
    }
}
