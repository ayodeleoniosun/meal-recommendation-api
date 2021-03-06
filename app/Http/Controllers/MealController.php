<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRecommendationRequest;
use App\Http\Interfaces\MealInterface;
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
     * Find Meal Details
     *
     * @OA\Get(
     *      path="/meals/{id}",
     *      tags={"Meals"},
     *      summary="Find meal and its respective allergies, main item and side items",
     *      description="Find meal and its respective allergies, main item and side items",
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
    
    public function find(int $id)
    {
        $response = $this->mealInterface->find($id);
        return response()->json($response, 200);
    }

    /**
     * Show meals recommendations for either single or multiple users
     *
     * @OA\Post(
     *      path="/meals/recommendations",
     *      summary="Show meals recommendations for either single or multiple  users",
     *      description="Show meals recommendations for either single or multiple  users",
     *      tags={"Meals"},
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           required={"users"},
     *             @OA\Property(
     *                  property="users",
     *                  type="array",
     *                  @OA\Items()
     *              ),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
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
     *                         property="recommendations",
     *                         type="array",
     *                         description="data",
     *                         @OA\Items
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


    public function recommendations(MealRecommendationRequest $request)
    {
        $response = $this->mealInterface->recommendations($request->all());
        return response()->json($response, 200);
    }
}
