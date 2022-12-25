<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|min:5|max:255|unique:users,username',
            'email'    => 'required|string|email|max:255|unique:users,'.'email',
            'role'     => 'required|integer|min:1|max:5',
            'password' => 'required|string|min:6|max:255',
        ];
    }

//    protected function failedValidation(Validator $validator)
//    {
//        $response = Controller::error($validator->errors(), false,Response::HTTP_UNPROCESSABLE_ENTITY, );
//        throw new ValidationException($validator, $response);
//    }
}
