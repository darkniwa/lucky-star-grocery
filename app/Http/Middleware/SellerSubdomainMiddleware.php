<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerSubdomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Get the current subdomain
         $subdomain = explode('.', request()->getHost())[0];

         // Check if the subdomain is 'seller'
         if ($subdomain === 'seller') {
             // Perform role-based authentication here
             if (!Auth::user() || !in_array(Auth::user()->role, ['owner', 'manager', 'cashier', 'courier', 'promodiser'])) {
                 Auth::logout(); // Log out the user
                 return redirect('/login')->with('error', 'You do not have permission to access this page.');
             }
         }
 
         return $next($request);
    }
}
