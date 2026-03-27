<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class IsUserAuth
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json(['message' => 'User not found'], 401);
            }
        } catch (JWTException $exception) {
            if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['message' => 'Token invalid'], 401);
            } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['message' => 'Token expired'], 401);
            } else {
                return response()->json(['message' => 'Token not provided'], 401);
            }
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
