<?php

namespace App;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Http\Models\User;
use Illuminate\Support\Str;

class Helper
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
        $user = User::where('bearer_token', $token)->first();
        
        if (!$user) {
            throw new CustomApiErrorResponseHandler("Unauthorized access.", 401);
        }

        return $user;
    }
}
