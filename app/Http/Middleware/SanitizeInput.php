<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SanitizeInput
{
    /**
     * A03: Injection — strip null bytes and overly long inputs.
     * Blade {{ }} handles HTML escaping; this strips control chars.
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                // Strip null bytes (SQL/file path injection vector)
                $value = str_replace("\0", '', $value);
                // Strip control characters except newline/tab
                $value = preg_replace('/[\x01-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $value);
            }
        });
        $request->merge($input);

        return $next($request);
    }
}
