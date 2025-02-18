<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/** @deprecated */
class customJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function handle($request, Closure $next)
    {
        // $allowedOrigins = config('allowedOrigins');

        // $origin = $request->headers->get('origin');
        
        // if (in_array($origin, $allowedOrigins)) {
            // header('Access-Control-Allow-Credentials: true');
        // }
        
        $segments = $request->segments();
        $token = $request->cookie('jwt');
        if ($token && @$segments[2] == 'refresh_token') {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
         
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expired'], 403);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Unauthorized or invalid token'], 401);
        }

        if (!$user) {
            return response()->json(['message' => 'Unauthorized or invalid token'], 401);
        }
 
        return $next($request);
    }
}
