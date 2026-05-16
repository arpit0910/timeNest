<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use App\Traits\ResolvesPermissions;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RBAC Middleware.
 *
 * Verifies that the authenticated user has the required permission
 * in the context of their currently active corporation workspace.
 *
 * Usage in routes: middleware(['rbac:attendance.view'])
 */
class RequirePermission
{
    use ApiResponse, ResolvesPermissions;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $permission Dot-notation permission e.g., 'users.manage'
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();
        $guard = $request->input('jwt_guard');

        // Platform admins bypass corp-level permission checks if they have the platform equivalent
        if ($guard === 'platform') {
            // For true platform super admins/owners, they can do anything.
            // In a stricter system, you'd resolve platform role permissions.
            // Given the master prompt, app_owner and app_super_admin have ['*'].
            if (in_array($request->input('jwt_role'), ['app_owner', 'app_super_admin'])) {
                return $next($request);
            }
            
            // For now, if they are using a platform token but trying to access corp routes,
            // we should probably block it unless we implement full platform-level RBAC resolution here.
            // The simplest approach is: this middleware is for corp routes.
            return $this->forbidden('Platform tokens cannot be used for corporation-scoped actions directly.');
        }

        $corpId = $request->input('jwt_corporation_id');

        if (!$corpId) {
            return $this->forbidden('No active corporation context found in token.');
        }

        // '*' represents absolute owner override (corporation_owner, corporation_super_admin)
        if ($this->hasPermission($user->id, (int) $corpId, '*')) {
            return $next($request);
        }

        // Check specific permission
        if (!$this->hasPermission($user->id, (int) $corpId, $permission)) {
            return $this->forbidden("You do not have the required permission: {$permission}");
        }

        return $next($request);
    }
}
