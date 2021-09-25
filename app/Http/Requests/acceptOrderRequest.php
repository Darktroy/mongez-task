<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class acceptOrderRequest extends FormRequest
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
            // 'order_id' => 'required|exists:orders,id',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',

        ];
    }
}
