<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Api\V1\Requests\UserRegistrationRequest;
use App\Exceptions\CustomApiErrorResponseHandler;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function register(Request $request)
    {
        $userRegistrationRequest  = new UserRegistrationRequest();
        $validator = Validator::make($request->all(), $userRegistrationRequest->rules(), $userRegistrationRequest->messages());

        if ($validator->fails()) {
            throw new CustomApiErrorResponseHandler($validator->errors()->first());
        }
        
        $response = $this->userInterface->register($request->all());
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $response = $this->userInterface->login($request->all());
        return response()->json($response, 200);
    }
}
