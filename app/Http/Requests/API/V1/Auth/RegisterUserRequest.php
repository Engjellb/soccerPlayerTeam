<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Constants\Validation\ValidationMessage;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'passwordConfirmation' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already taken',
            'passwordConfirmation.same' => 'Passwords do not match',
            '*.*' => ValidationMessage::INVALID_VALUE
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(422, $validator->errors()->first()));
    }
}
