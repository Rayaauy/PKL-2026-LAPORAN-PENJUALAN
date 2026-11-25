<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecurityAuditLog
{
    /**
     * A09: Security Logging and Monitoring Failures
     * Log sensitive actions for audit trail.
     */

    private array $sensitiveRoutes = [
        'login', 'register', 'logout',
        'admin.blog.store', 'admin.blog.update', 'admin.blog.destroy',
        'categories.destroy', 'products.destroy', 'transactions.destroy',
        'business.update',
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log sensitive route access
        $routeName = $request->route()?->getName();

        if ($routeName && in_array($routeName, $this->sensitiveRoutes)) {
            $statusCode = $response->getStatusCode();

            if (in_array($statusCode, [200, 201, 302])) {
                Log::channel('single')->info('Security audit', [
                    'route'     => $routeName,
                    'method'    => $request->method(),
                    'ip'        => $request->ip(),
                    'user_id'   => auth()->id() ?? 'guest',
                    'status'    => $statusCode,
                    'ua'        => substr($request->userAgent() ?? '', 0, 200),
                    'time'      => now()->toIso8601String(),
                ]);
            }

            // Log failed auth attempts separately
            if ($routeName === 'login' && $statusCode === 302 && str_contains($response->headers->get('Location', ''), 'login')) {
                Log::channel('single')->warning('Failed login attempt', [
                    'ip'    => $request->ip(),
                    'email' => $request->input('email'),
                    'ua'    => substr($request->userAgent() ?? '', 0, 200),
                    'time'  => now()->toIso8601String(),
                ]);
            }
        }

        return $response;
    }
}
