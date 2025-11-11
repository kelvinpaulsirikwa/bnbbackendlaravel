<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $normalizedRole = $this->normalizeRole($user->role);

        if (in_array($normalizedRole, array_map([$this, 'normalizeRole'], $roles), true)) {
            return $next($request);
        }

        return $this->redirectForRole($normalizedRole);
    }

    /**
     * Redirect user to the appropriate location based on role.
     */
    protected function redirectForRole(?string $role): Response
    {
        return match ($role) {
            'bnbadmin' => redirect()->route('adminpages.dashboard'),
            'bnbowner' => redirect()->route('bnbowner.motel-selection'),
            default => redirect('/'),
        };
    }

    /**
     * Normalize different spellings/aliases of role names.
     */
    protected function normalizeRole(?string $role): ?string
    {
        return match (trim(strtolower((string) $role))) {
            'bnbonwner' => 'bnbowner',
            default => $role,
        };
    }
}

