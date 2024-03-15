<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateToken
{
    public function handle($request, Closure $next)
    {
        // Check if the request has an Authorization header
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['message' => 'Unauthorized: Bearer token missing'], 401);
        }

        // Retrieve the token from the Authorization header
        $authorizationHeader = $request->header('Authorization');
        $token = $this->parseBearerToken($authorizationHeader);

        // Check if the token is in Bearer token format
        if (!$token) {
            return response()->json(['message' => 'Unauthorized: Invalid Bearer token format'], 401);
        }

        return $next($request);
    }

    protected function parseBearerToken($authorizationHeader)
    {
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            return substr($authorizationHeader, 7);
        }

        return null;
    }
}

