<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\MealInterface;
use App\Http\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegistrationRequest;
class UserController extends Controller
{
    protected $userInterface;
    protected $mealInterface;

    public function __construct(UserInterface $userInterface, MealInterface $mealInterface)
    {
        $this->userInterface = $userInterface;
        $this->mealInterface = $mealInterface;
    }

    /**
     * User Registration
     *
     * @OA\Post(
     *      path="/users/register",
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

    public function register(UserRegistrationRequest $request)
    {
        $response = $this->userInterface->register($request->all());
        return response()->json($response, 201);
    }

    /**
     * User Login
     *
     * @OA\Post(
     *      path="/users/login",
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

    /**
     * Show logged user meals recommendation
     *
     * @OA\Get(
     *      path="/users/meals/recommendations",
     *      tags={"Users"},
     *      security={{"bearer_token":{}}},
     *      summary="Show logged in user meal recommendations based on his allergy",
     *      description="Show logged in user meal recommendations based on his allergy",
     *
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(
        *                  property="status",
        *                  type="string",
        *                  description="The response code"
     *                 ),
     *                 @OA\Property(
     *                      property="recommendations",
     *                      type="array",
     *                      description="The response data",
     *                      @OA\Items()
     *                  ),
     *              )
     *           )
     *         }
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=401, description="Unauthorized access"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=500, description="An error occured."),
     *     )
     */

    public function mealRecommendations(Request $request)
    {
        $users = ['users' => (array) $request->user()->id];
        $response = $this->mealInterface->recommendations($users);
        return response()->json($response, 200);
    }
}
