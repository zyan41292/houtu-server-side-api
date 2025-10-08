<?php

namespace App\Http\Middleware;

use Closure;
use Houtu\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthenticate
{
    /**
     * JWT token authentication middleware.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log token for debugging
        $token = $request->bearerToken();
        \Log::debug('JWT Token:', ['token' => $token]);

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return ApiResponse::error('User not found', 401);
            }
        } catch (TokenExpiredException $e) {
            return ApiResponse::error('Token has expired', 401);
        } catch (TokenInvalidException $e) {
            return ApiResponse::error('Token is invalid', 401);
        } catch (\Throwable $e) {
            return ApiResponse::error('Token decode error', 401);
        }

        auth()->setUser($user);
        return $next($request);
    }
}
