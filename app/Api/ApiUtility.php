<?php

namespace App\Api;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\V1\Models\ActiveStatus;
use App\Api\V1\Models\User;
use Illuminate\Support\Str;

class ApiUtility
{
    public static function generateBearerToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public static function decodeBearerToken($request)
    {
        $header = $request->header('Authorization', '');
        
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return null;
    }

    public static function authUser($token)
    {
        $user = User::where('bearer_token', $token)->active()->first();
        
        if (!$user) {
            throw new CustomApiErrorResponseHandler("Unauthorized access.", 401);
        }

        return $user;
    }
}
