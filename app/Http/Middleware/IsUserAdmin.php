<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user= auth('api')->user();
        if($user->role != 'admin'){
            return response()->json([
                'message' => 'Necesitas ser admin para acceder a esta ruta'
            ], 403);
        }else{
            return $next($request);
        }

    }
}
