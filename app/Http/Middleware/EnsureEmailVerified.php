<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the authenticated user has verified their email address.
 *
 * Returns 403 with a resend option if email is not verified.
 */
class EnsureEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email address not verified. Please verify your email before continuing.',
                'data'    => ['can_resend' => true],
                'errors'  => null,
                'meta'    => null,
            ], 403);
        }

        return $next($request);
    }
}
