<?php

namespace App\Http\Requests\API\V1\Player;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlayerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|in:defender,midfielder,forward',
            'playerSkills' => 'required|array|min:1',
            'playerSkills.*.skill' => 'required|string|distinct|in:defense,attack,strength,stamina,speed',
            'playerSkills.*.value' => 'numeric|between:1,100'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['message' => $validator->errors()->first()], 422)
        );
    }

    /**
     * Get custom message for all attributes with any rule
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            '*.*' => 'Invalid value for :attribute',
            'playerSkills.*.*' => 'Invalid value for :attribute'
        ];
    }

    /**
     * Get custom names for requested attributes
     *
     * @return string[]
     */
    public function attributes()
    {
        return [
          'playerSkills.*.skill' => 'skill',
          'playerSkills.*.value' => 'value'
        ];
    }
}
