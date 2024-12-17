<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = $request->user()->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }
        $redirectRoute = $this->getRedirectRoute($userRole);

        return redirect($redirectRoute)->with('error', 'You do not have permission to access this page.');
    }

    private function getRedirectRoute($userRole)
    {
        switch ($userRole) {
            case 'super admin':
                return '/dashboard';
            case 'admin':
                return '/disposision';
            default:
                return '/';
        }
    }
}
