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
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if ($request->user() === null) {
            abort(403, 'Unauthorized');
        }

        // Support pipe-separated roles (role:admin|apoteker)
        $roleList = explode('|', $roles);
        $hasRole = false;
        
        foreach ($roleList as $role) {
            if ($request->user()->hasRole(trim($role))) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
