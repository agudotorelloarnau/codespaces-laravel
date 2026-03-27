<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;

class IsUserAuth
{
    public function handle(Request $request, Closure $next)
    {
        $authorization = $request->header('Authorization');

        if (! $authorization || ! str_starts_with($authorization, 'Bearer ')) {
            return response()->json(['message' => 'Token missing'], 401);
        }

        $token = trim(str_replace('Bearer', '', $authorization));
        $jwtService = new JwtService();
        $payload = $jwtService->decode($token);

        if (! $payload || empty($payload->sub)) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user = User::find($payload->sub);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
