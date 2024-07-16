<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Check if the requested URL matches any of the public routes
            if ($request->is('/') || $request->is('home') || $request->is('products') || $request->is('contact') || $request->is('product/*')) {
                return null; // Allow access to these routes for all users
            }
    
            return redirect('/login'); // Redirect to the login page for other routes
        }
    }

}
