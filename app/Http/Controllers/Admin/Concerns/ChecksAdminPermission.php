<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait ChecksAdminPermission
{
    /**
     * Run the same permission check as the admin.permission middleware.
     * Call from controller constructor so no action runs without permission.
     * If the current route requires a permission and the user doesn't have it, redirects to dashboard with message.
     */
    protected function authorizeAdminRoute(): void
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'bnbadmin') {
            return;
        }

        $permissions = $user->admin_permissions;
        if ($permissions === null || (is_array($permissions) && count($permissions) === 0)) {
            return;
        }

        $routeName = Route::currentRouteName() ?? '';
        if ($routeName === '') {
            return;
        }

        $requiredPermission = $this->getRequiredPermissionForRoute($routeName);
        if ($requiredPermission === null) {
            return;
        }

        if (!in_array($requiredPermission, $permissions, true)) {
            throw new HttpResponseException(
                redirect()->route('adminpages.dashboard')
                    ->with('error', 'You do not have permission to access this area.')
            );
        }
    }

    protected function getRequiredPermissionForRoute(string $routeName): ?string
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
