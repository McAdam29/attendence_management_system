<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('X-Custom-Auth')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Content-Security-Policy', "default-src 'self'");

        return $response;
    }
        
    public function terminate($request, $response)
    {
    // Custom logic after the response is sent
    // For example, logging or cleaning up resources
    }
    public function getMiddlewarePriority()
    {
        return 100; // Set a custom priority for this middleware
    }
    public function getMiddlewareGroups()
    {
        return ['web', 'api']; // Specify the middleware groups this middleware belongs to
    }
    public function getMiddlewareAliases()
    {
        return [
            'custom_auth' => self::class, // Define an alias for this middleware
        ];
    }
    
}
