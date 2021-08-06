<?php

namespace App\Api\V1\Middleware;

use App\Api\ApiUtility;
use App\Exceptions\CustomApiErrorResponseHandler;
use Closure;
use Illuminate\Http\Request;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = ApiUtility::decodeBearerToken($request);
        
        if (!$token) {
            throw new CustomApiErrorResponseHandler("Unauthorized access.", 401);
        }
        
        $user = ApiUtility::authUser($token);
        $request->merge(['auth_user' => $user]);
        
        return $next($request);
    }
}
