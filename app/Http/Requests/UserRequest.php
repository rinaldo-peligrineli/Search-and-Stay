<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8'
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errors found',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'The NAME field is a mandatory',
            'email.required' => 'The EMAIL field is a mandatory',
            'email.email' => 'The EMAIL field is a invalid value',
            'password.required' => 'The PASSWORD field is a mandatory',
            'password.min' => 'The PASSWORD field must have at least 8 alphanumeric chars'
        ];
    }
}
