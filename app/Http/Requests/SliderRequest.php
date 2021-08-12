<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        if(request()->is('api/slider-add/*')) {
            return [
                'slider_photo' => 'required|array',
                'slider_photo.*' => 'required|image'
            ];
        }
        elseif (request()->is('api/slider-order')) {
            return [
                'order' => 'required|array',
                'product_id' => 'required|integer'
            ];
        }
        elseif (request()->is('api/slider-delete')) {
            return [
              'ids' => 'required|array'
            ];
        }

    }

    public function failedValidation(Validator $validator)
    {
        throw new RequestValidateException($validator->getMessageBag()->first());
    }
}
