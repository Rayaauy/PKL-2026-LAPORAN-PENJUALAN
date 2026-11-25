<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class LoginRateLimiter
{
    /**
     * Max attempts before lockout.
     * A07: Identification and Authentication Failures
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST') && $request->routeIs('login')) {
            // Key: IP + email combination prevents per-IP bypass
            $key = 'login:' . sha1($request->ip() . '|' . strtolower($request->input('email', '')));

            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);

                // A09: Log brute force attempt
                Log::warning('Login brute force detected', [
                    'ip'    => $request->ip(),
                    'email' => $request->input('email'),
                    'ua'    => $request->userAgent(),
                ]);

                return back()->withErrors([
                    'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
                ])->withInput($request->only('email'));
            }

            RateLimiter::hit($key, 300); // decay 5 minutes
        }

        return $next($request);
    }
}
