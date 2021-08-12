<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserChangeRequest extends FormRequest
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
            'name' => 'string|min:3|max:50',
            'email' => 'email|min:5|max:50',
            'password' => 'string|min:8|max:50|confirmed',
            'current_password' => 'string|min:3|max:50'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new RequestValidateException($validator->getMessageBag()->first());
    }
}
