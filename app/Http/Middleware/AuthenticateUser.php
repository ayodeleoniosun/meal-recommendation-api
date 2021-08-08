<?php

namespace App\Http\Middleware;

use App\Helpers;
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
        $token = Helpers::decodeBearerToken($request);
        
        if (!$token) {
            throw new CustomApiErrorResponseHandler("Unauthorized access.", 401);
        }
        
        $user = Helpers::authUser($token);
        $request->merge(['auth_user' => $user]);
        
        return $next($request);
    }
}
