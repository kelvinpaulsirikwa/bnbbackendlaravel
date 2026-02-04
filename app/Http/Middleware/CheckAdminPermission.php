<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'bnbadmin') {
            return $next($request);
        }

        // Full admin: null or empty admin_permissions means access to everything
        $permissions = $user->admin_permissions;
        if ($permissions === null || (is_array($permissions) && count($permissions) === 0)) {
            return $next($request);
        }

        $routeName = $request->route() ? $request->route()->getName() : '';
        if ($routeName === '') {
            return $next($request);
        }

        $requiredPermission = $this->getRequiredPermission($routeName);
        if ($requiredPermission === null) {
            return $next($request);
        }

        if (!in_array($requiredPermission, $permissions, true)) {
            return redirect()->route('adminpages.dashboard')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }

    protected function getRequiredPermission(string $routeName): ?string
    {
        $map = config('admin_route_permissions', []);
        foreach ($map as $routePrefix => $permission) {
            if (str_starts_with($routeName, $routePrefix)) {
                return $permission;
            }
        }
        return null;
    }
}
