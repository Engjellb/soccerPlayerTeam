<?php

namespace App\Http\Requests\API\V1\Team;

use App\Constants\Validation\ValidationMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeamRequest extends FormRequest
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
            'name' => 'required|string|unique:teams|max:255'
        ];
    }

    public function messages()
    {
        return [
            '*.*' => ValidationMessage::INVALID_VALUE
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(422, $validator->errors()->first()));
    }
}
