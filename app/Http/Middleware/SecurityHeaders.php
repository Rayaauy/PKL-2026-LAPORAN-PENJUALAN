<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only add headers to HTTP responses (not binary downloads etc.)
        if (!method_exists($response, 'header')) {
            return $response;
        }

        // A05: Security Misconfiguration — Security Headers
        $response->header('X-Content-Type-Options',    'nosniff');
        $response->header('X-Frame-Options',           'DENY');
        $response->header('X-XSS-Protection',          '1; mode=block');
        $response->header('Referrer-Policy',           'strict-origin-when-cross-origin');
        $response->header('Permissions-Policy',        'camera=(), microphone=(), geolocation=()');

        // Content Security Policy — prevent XSS/injection
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com",
            "style-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com fonts.gstatic.com",
            "font-src 'self' fonts.gstatic.com cdn.jsdelivr.net",
            "img-src 'self' data: blob:",
            "connect-src 'self'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ]);
        $response->header('Content-Security-Policy', $csp);

        // Remove fingerprinting headers
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
