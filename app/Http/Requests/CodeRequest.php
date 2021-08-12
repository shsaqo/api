<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
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
        if (request()->method == 'POST'):
            return [
                'name' => 'required|string|max:250',
                'code' => 'required|string|max:5000',
                'type' => 'required|in:1,2'
            ];
        else:
            return [
                'name' => 'string|max:250',
                'code' => 'string|max:5000',
                'type' => 'in:1,2'
            ];
        endif;
    }

    public function failedValidation(Validator $validator)
    {
        throw new RequestValidateException($validator->getMessageBag()->first());
    }
}
