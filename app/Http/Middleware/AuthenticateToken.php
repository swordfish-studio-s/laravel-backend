<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the request has a token
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['message' => 'Unauthorized no token found'], 404);
        }

        $token = $request->header('Authorization');

        // Check if the token exists in the cache
        if (!Cache::has($token)) {
            return response()->json(['message' => 'Unauthorized no valid token found'], 401);
        }


        return $next($request);
    }
}
