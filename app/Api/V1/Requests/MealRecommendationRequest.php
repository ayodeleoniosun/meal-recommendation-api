<?php

namespace App\Api\V1\Requests;

use Illuminate\Http\Request;

class MealRecommendationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users' => 'required|array'
        ];
    }

    /**
    * Custom message for validation
    *
    * @return array
    */
    public function messages()
    {
        return [
            'users.required' => 'Select at least one user',
            'users.array' => 'Invalid format for users'
        ];
    }
}
