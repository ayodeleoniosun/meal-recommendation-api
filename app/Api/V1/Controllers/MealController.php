<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Interfaces\MealInterface;
use Illuminate\Http\Request;

class MealController extends Controller
{
    protected $mealInterface;

    public function __construct(MealInterface $mealInterface)
    {
        $this->mealInterface = $mealInterface;
    }
    
    /**
     * Show All Meals
     *
     * @OA\Get(
     *      path="/meals",
     *      tags={"Meals"},
     *      summary="Get list of meals",
     *      description="Returns list of meals",
     *
     *      @OA\Response(
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
     *                      type="array",
     *                      property="meals",
     *                      description="The response data",
     *                      @OA\Items()
     *                  ),
     *              )
     *           )
     *         }
     *      ),
     *
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=500, description="An error occured."),
     *     )
     */

    public function index(Request $request)
    {
        $response = $this->mealInterface->index($request->all());
        return response()->json($response, 200);
    }

    /**
     * Show Single Meal Details
     *
     * @OA\Get(
     *      path="/meals/{id}",
     *      tags={"Meals"},
     *      summary="Show meals and their respective allergies, main item and side items",
     *      description="Show meals and their respective allergies, main item and side items",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="meal id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *      @OA\Response(
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
     *                      type="object",
     *                      property="meal",
     *                      description="The response data",
     *                  ),
     *              )
     *           )
     *         }
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=500, description="An error occured."),
     *     )
     *
     */
    
    public function show(int $id)
    {
        $response = $this->mealInterface->show($id);
        return response()->json($response, 200);
    }

    /**
     * Show logged user meals recommendation
     *
     * @OA\Get(
     *      path="/users/meals/recommendations",
     *      tags={"Meals"},
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

    public function userRecommendations(Request $request)
    {
        $response = $this->mealInterface->userRecommendations($request->all());
        return response()->json($response, 200);
    }
}
