<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckJwtToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Parse & authenticate user from JWT
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json(['error' => 'User not found'], 401);
            }

            // Extra check → token expiry from DB
            if ($user->token_expires_at && now()->greaterThan($user->token_expires_at)) {
                return response()->json(['error' => 'Token expired'], 401);
            }

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        return $next($request);
    }
}
