<?php

namespace App\Http\Middleware;

use App\Services\System\AuthService;
use Closure;
use Houtu\Enums\AdminErrorCode;
use Houtu\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthenticate
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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
        $this->authService->isLogin();
        return $next($request);
    }
}
