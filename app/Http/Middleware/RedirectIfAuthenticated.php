<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? ['web'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $allowedRoutes = [
                    'password.request',
                    'password.email',
                    'password.reset',
                    'password.update',
                ];

                $currentRouteName = $request->route() ? $request->route()->getName() : null;

                if (in_array($currentRouteName, $allowedRoutes)) {
                    return $next($request);
                }

                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
