<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class InvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->id === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'product_permission' => 'in:0,1,2',
            'special_permission' => 'in:0,1,2',
            'domain_permission' => 'in:0,1,2',
            'position' => 'required|string|max:50'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new RequestValidateException($validator->getMessageBag()->first());
    }
}
