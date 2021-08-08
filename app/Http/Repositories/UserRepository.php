<?php

namespace App\Http\Repositories;

use App\Exceptions\CustomApiErrorResponseHandler;
use App\Helper;
use App\Http\Models\User;
use App\Http\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;

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
            'bearer_token' => Helper::generateBearerToken(),
            'password' => bcrypt($data['password'])
        ]);
        
        return [
            'status' => 'success',
            'user' => $user,
            'message' => 'Registration successful.'
        ];
    }

    public function login(array $data) : array
    {
        $data = (object) $data;

        if (!Auth::attempt([
            'email_address' => $data->email_address,
            'password' => $data->password
        ])) {
            throw new CustomApiErrorResponseHandler("Incorrect login credentials. Try again.");
        }

        $user = auth()->user();
        
        return [
            'status' => 'success',
            'user' => $user,
            'message' => 'Login successful'
        ];
    }
}
