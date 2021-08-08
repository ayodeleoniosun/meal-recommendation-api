<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\AllergyInterface;
use Illuminate\Http\Request;
use App\Http\Requests\PickAllergyRequest;
use App\Exceptions\CustomApiErrorResponseHandler;
use Illuminate\Support\Facades\Validator;

class AllergyController extends Controller
{
    protected $allergyInterface;

    public function __construct(AllergyInterface $allergyInterface)
    {
        $this->allergyInterface = $allergyInterface;
    }

    /**
     * @OA\Get(
     *      path="/users/my-allergies",
     *      tags={"Users"},
     *      security={{"bearer_token":{}}},
     *      summary="Show user allergies",
     *      description="Show user allergies",
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
     *                      property="allergies",
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

    public function myAllergies(Request $request)
    {
        dd("sss");
        $response = $this->allergyInterface->myAllergies($request->all());
        return response()->json($response, 200);
    }

    /**
     * Pick Allergy
     *
     * @OA\Post(
     *
     *      path="/users/allergies",
     *      summary="Pick one or more allergies",
     *      description="Pick one or more allergies",
     *      security={{"bearer_token":{}}},
     *      tags={"Users"},
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *           type="object",
     *           required={"allergies"},
     *             @OA\Property(
     *                  property="allergies",
     *                  type="array",
     *                  @OA\Items()
     *              ),
     *          )
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
     *                         property="allergies",
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

    public function pickAllergies(Request $request)
    {
        $allergyRequest  = new PickAllergyRequest();
        $validator = Validator::make($request->all(), $allergyRequest->rules(), $allergyRequest->messages());

        if ($validator->fails()) {
            throw new CustomApiErrorResponseHandler($validator->errors()->first());
        }
        
        $response = $this->allergyInterface->pickAllergies($request->all());
    
        return response()->json($response, 201);
    }
}
