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

    /**
     * User Registration
     *
     * @OA\Post(
     *      path="/accounts/register",
     *      summary="Sign up a new account",
     *      description="Sign up a new account",
     *      tags={"Accounts"},
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           required={"first_name","last_name","email_address","phone_number", "password"},
     *             @OA\Property(property="first_name", type="string"),
     *             @OA\Property(property="last_name", type="string"),
     *             @OA\Property(property="email_address", type="string"),
     *             @OA\Property(property="phone_number", type="string"),
     *             @OA\Property(property="password", type="string"),
     *        )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful registration",
     *          content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="user",
     *                         type="array",
     *                         description="data",
     *                         @OA\Items
     *                     ),
     *                      @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                    )
     *                 )
     *              }
     *       ),
     *      @OA\Response(
     *              response=400,
     *              description="Bad request",
     *              content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                    )
     *                 )
     *              }
     *      ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="An error occured"),
     *
     * )
     *
     */

    public function register(Request $request)
    {
        $userRegistrationRequest  = new UserRegistrationRequest();
        $validator = Validator::make($request->all(), $userRegistrationRequest->rules(), $userRegistrationRequest->messages());

        if ($validator->fails()) {
            throw new CustomApiErrorResponseHandler($validator->errors()->first());
        }
        
        $response = $this->userInterface->register($request->all());
        return response()->json($response, 201);
    }

    /**
     * User Login
     *
     * @OA\Post(
     *      path="/accounts/login",
     *      summary="Login to an existing account",
     *      description="Login to an existing account",
     *      tags={"Accounts"},
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           required={"email_address", "password"},
     *             @OA\Property(property="email_address", type="string"),
     *             @OA\Property(property="password", type="string"),
     *        )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful login",
     *          content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="user",
     *                         type="array",
     *                         description="data",
     *                         @OA\Items
     *                     ),
     *                      @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                    )
     *                 )
     *              }
     *       ),
     *      @OA\Response(
     *              response=400,
     *              description="Bad request",
     *              content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                    )
     *                 )
     *              }
     *      ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="An error occured"),
     *
     * )
     *
     */

    public function login(Request $request)
    {
        $response = $this->userInterface->login($request->all());
        return response()->json($response, 200);
    }
}
