<?php

namespace App\Api\V1\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Api\ApiUtility;
use App\Api\V1\Models\User;
use App\Api\V1\Interfaces\UserInterface;

class UserRepository implements UserInterface
{
    public function register(array $data): array
    {
        $user = User::getUserByEmail($data['email_address']);
        
        if ($user) {
            throw new CustomApiErrorResponseHandler("User already exists. Kindly use a different email address");
        }

        $user = User::create([
            'first_name' => strtolower($data['first_name']),
            'last_name' => strtolower($data['last_name']),
            'phone_number' => $data['phone_number'],
            'email_address' => strtolower($data['email_address']),
            'bearer_token' => ApiUtility::generateBearerToken(),
            'password' => bcrypt($data['password'])
        ]);
        
        return [
            'user' => $user,
            'message' => 'Registration successful.'
        ];
    }
}