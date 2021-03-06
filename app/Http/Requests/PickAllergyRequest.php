<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class PickAllergyRequest extends FormRequest
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
            'allergies' => 'required|array',
            'allergies.*' => 'exists:allergies,id'
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
            'allergies.required' => 'Select at least one allergy',
            'allergies.array' => 'Invalid format for allergies'
        ];
    }
}
