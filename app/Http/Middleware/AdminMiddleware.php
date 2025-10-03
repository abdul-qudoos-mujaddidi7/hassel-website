<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Authentication required.',
                'error' => 'Unauthenticated'
            ], 401);
        }

        $user = auth()->user();

        // Check if user has admin privileges
        // This can be expanded based on your user role system
        if (!$this->isAdmin($user)) {
            return response()->json([
                'message' => 'Admin access required.',
                'error' => 'Forbidden'
            ], 403);
        }

        // Log admin access for security audit
        $this->logAdminAccess($request, $user);

        return $next($request);
    }

    /**
     * Check if user has admin privileges
     */
    private function isAdmin($user): bool
    {
        // Method 1: Check for admin role (if using roles)
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole('admin') || $user->hasRole('super-admin');
        }

        // Method 2: Check for admin helper on the model
        if (method_exists($user, 'isAdmin')) {
            return $user->isAdmin();
        }

        // Method 3: Check for admin email domains (temporary solution)
        $adminEmails = [
            'admin@mountagro.af',
            'super@mountagro.af',
            // Add more admin emails as needed
        ];

        return in_array($user->email, $adminEmails);
    }

    /**
     * Log admin access for security audit
     */
    private function logAdminAccess(Request $request, $user): void
    {
        // Log admin access for security monitoring
        \Illuminate\Support\Facades\Log::info('Admin access', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'route' => $request->route()?->getName(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'timestamp' => now()->toISOString(),
        ]);
    }
}
