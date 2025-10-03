<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via session (web)
        if (auth()->check()) {
            return $next($request);
        }

        // Check if user is authenticated via API token (Bearer or URL parameter)
        $tokenValue = $request->bearerToken() ?? $request->query('token');
        if ($tokenValue) {
            $token = \Laravel\Sanctum\PersonalAccessToken::findToken($tokenValue);
            if ($token && $token->tokenable) {
                auth()->login($token->tokenable);
                return $next($request);
            }
        }

        // If not authenticated, return JSON response for API calls
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // For web requests, redirect to login
        return redirect('/admin/login');
    }
}
