<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthenticateToken
{
    public function handle($request, Closure $next)
    {
        // Check if the request has an Authorization header
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['message' => 'Unauthorized: No token found'], 401);
        }

        // Retrieve the token from the Authorization header
        $token = $request->header('Authorization');

        // Check if the token exists in the cache
        if (!Cache::has($token)) {
            return response()->json(['message' => 'Unauthorized: Invalid token'], 401);
        }

        return $next($request);
    }
}
