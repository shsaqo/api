<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'domain' => 'string|min:5|max:100|required',
            'url' => 'string|min:5|max:100|required',
            'name' => 'string|min:5|max:100|required',
            'trello' => 'string|min:5|max:100|required',
            'description' => 'string|min:5|max:1000|nullable',
            'info' => 'string|min:5|max:1000|nullable',
            'type' => 'string|max:250|required',
            'template' => 'integer|required',
            'sale' => 'integer|required',
            'count' => 'integer|required',
            'price' => 'between:0,99.99|required',
            'contact_type' => 'integer|required',
            'head_photo' => 'image|required',
            'footer' => 'image',
            'footer_photo' => 'string',
            'youtube' => 'string|min:10|max:250|nullable',
            'alert_1' => 'string|min:10|max:100|nullable',
            'alert_2' => 'string|min:10|max:100|nullable',
            'alert_3' => 'string|min:10|max:100|nullable',
            'alert_4' => 'string|min:10|max:100|nullable',

            'slider_photo' => 'array',
            'slider_photo.*' => 'image',

            'description_one_type' => 'integer',
            'description_one_name' => 'string|nullable',
            'description_one_photo' => 'image',
            'description_one_description' => 'array',

            'description_two_type' => 'integer',
            'description_two_name' => 'string|nullable',
            'description_two_photo' => 'image',
            'description_two_description' => 'array'

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new RequestValidateException($validator->getMessageBag()->first());
    }
}
