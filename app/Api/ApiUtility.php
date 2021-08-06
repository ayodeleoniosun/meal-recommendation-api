<?php

namespace App\Api;

class ApiUtility
{
    public static function generateBearerToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}
