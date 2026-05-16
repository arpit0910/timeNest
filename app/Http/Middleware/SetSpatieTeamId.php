<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSpatieTeamId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $corpId = $request->input('jwt_corporation_id');

        if ($corpId) {
            setPermissionsTeamId($corpId);
        } else {
            setPermissionsTeamId(null);
        }

        return $next($request);
    }
}
