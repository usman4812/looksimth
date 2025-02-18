<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiValidationKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('x-api-key');

        // Validate the API key (You can compare it with stored keys in your database or config)
        if ($apiKey !== '4d67d97a4e659148982asf6f819fc5lo0z5') {
            return response()->json(['statusCode' => 401, 'error' => 'Unauthorized Request'], 401);
            
        }
        
        return $next($request);
    }
}
