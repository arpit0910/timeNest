<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTempTokenPurpose
{
    public function handle(Request $request, Closure $next, string $purpose): Response
    {
        if (! app()->bound(JwtContext::class)) {
            return $this->errorResponse('Unauthenticated. JWT context missing.', 401);
        }

        $context = app(JwtContext::class);

        if (! $context->isTemp() || $context->purpose !== $purpose) {
            return $this->errorResponse('Access denied. Invalid temporary token purpose.', 403);
        }

        return $next($request);
    }

    private function errorResponse(string $message, int $status): Response
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => null,
            'meta' => null,
        ], $status);
    }
}
