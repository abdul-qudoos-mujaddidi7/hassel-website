<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminWebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with(
                'warning',
                'Please sign in to access the admin dashboard.'
            );
        }

        $user = Auth::user();

        if (!method_exists($user, 'isAdmin') || !$user->isAdmin()) {
            Auth::logout();

            return redirect()->route('admin.login')->with(
                'error',
                'You do not have permission to access the admin area.'
            );
        }

        return $next($request);
    }
}


