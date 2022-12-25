<?php

namespace App\Http\Requests\API\V1\Player;

use App\Constants\Validation\ValidationMessage;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlayerRequest extends FormRequest
{
    use ApiResponse;

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
            'playerId' => 'sometimes|required|numeric|exists:players,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|in:defender,midfielder,forward',
            'playerSkills' => 'required|array|min:1',
            'playerSkills.*.skill' => 'required|string|distinct|in:defense,attack,strength,stamina,speed',
            'playerSkills.*.value' => 'numeric|between:1,100'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(422, $validator->errors()->first()));
    }

    /**
     * Get custom message for all attributes with any rule
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            '*.*' => ValidationMessage::INVALID_VALUE,
            'playerSkills.*.*' => ValidationMessage::INVALID_VALUE
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

    /**
     * Merge playerId to the rules if the route parameter is present on request
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->route('playerId')) {
            $this->merge(['playerId' => $this->route('playerId')]);
        }
    }
}
