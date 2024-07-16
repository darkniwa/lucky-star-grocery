<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $hasRole = false;

            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    $hasRole = true;
                    break; // Exit the loop as soon as a matching role is found
                }
            }

            if ($hasRole) {
                return $next($request);
            } else {
                // If the user doesn't have any of the roles, log them out
                auth()->logout();

                // Redirect to the login page after logout
                return redirect()->route('login');
            }
        }

        // If the user is not authenticated, you can handle it as needed
        // For example, you can redirect them to the login page
        return redirect()->route('login');
    }
}
