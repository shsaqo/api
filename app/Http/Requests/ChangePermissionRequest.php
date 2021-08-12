<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangePermissionRequest extends FormRequest
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
            'id' => 'required|integer',
            'product_permission' => 'in:0,1,2',
            'special_permission' => 'in:0,1,2',
            'domain_permission' => 'in:0,1,2',
            'position' => 'string|max:100'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new RequestValidateException($validator->getMessageBag()->first());
    }
}
