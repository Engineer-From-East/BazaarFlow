<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Essential for checking who is logged in

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is logged in AND their is_admin column is 1
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request); // Let them through
        }

        // Otherwise, kick them out with a 403 Forbidden error
        abort(403, 'Unauthorized action. Admins only.');
    }
}