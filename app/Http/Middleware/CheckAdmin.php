<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $user = JWTAuth::parseToken()->authenticate();
        // $webuser = auth()->user();
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (! $user->is_admin) {
            return response()->json([
                'message' => 'Not authorized'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
