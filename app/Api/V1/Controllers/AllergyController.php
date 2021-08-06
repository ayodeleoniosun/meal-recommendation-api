<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Interfaces\AllergyInterface;
use Illuminate\Http\Request;
use App\Api\V1\Requests\PickAllergyRequest;
use App\Exceptions\CustomApiErrorResponseHandler;
use Illuminate\Support\Facades\Validator;

class AllergyController extends Controller
{
    protected $allergyInterface;

    public function __construct(AllergyInterface $allergyInterface)
    {
        $this->allergyInterface = $allergyInterface;
    }

    public function myAllergies(Request $request)
    {
        $response = $this->allergyInterface->myAllergies($request->all());
        return response()->json($response, 200);
    }

    public function pickAllergies(Request $request)
    {
        $allergyRequest  = new PickAllergyRequest();
        $validator = Validator::make($request->all(), $allergyRequest->rules(), $allergyRequest->messages());

        if ($validator->fails()) {
            throw new CustomApiErrorResponseHandler($validator->errors()->first());
        }
        
        $response = $this->allergyInterface->pickAllergies($request->all());
    
        return response()->json($response, 200);
    }
}
