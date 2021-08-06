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

    public function index(Request $request)
    {
        $response = $this->mealInterface->index($request->all());
        return response()->json($response, 200);
    }

    public function show(int $id)
    {
        $response = $this->mealInterface->show($id);
        return response()->json($response, 200);
    }

    public function userRecommendations(Request $request)
    {
        $response = $this->mealInterface->userRecommendations($request->all());
        return response()->json($response, 200);
    }
}
