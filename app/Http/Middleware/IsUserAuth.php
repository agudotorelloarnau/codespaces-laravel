<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class IsUserAuth
{

    public function handle(Request $request, Closure $next)
{
    if (! $user = auth('api')->user()) {
        return response()->json(['message' => 'Unauthorized Invalid Token'], 401);
    }

    $request->setUserResolver(fn () => $user);
    return $next($request);
}
}
