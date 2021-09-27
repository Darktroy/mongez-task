<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class acceptSpecificOrderRequest extends FormRequest
{

    // Redirect to the given url
    public $redirect;

    // Redirect to a given route
    public $redirectRoute;

    // Redirect to a given action
    public $redirectAction;


    /**
     * Get the URL to redirect to on a validation error.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        // Or just redirect back
        return 'error';
    }


  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id'              => 'required|exists:orders,id|exists:order_statuses,order_id,status,intiate,worker_id,'.Auth::user()->id, 
            'status'                => 'required|in:start,refused',
            // 'user_status'           =>'required|exists:workers,user_id,'.Auth::user()->id.',status,!=busy',
            // 'order_status'          => 'required|exists:order_statuses,order_id,status,intiate,worker_id,'.Auth::user()->id, 4
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'order_id.*'    => 'The order id not exist',
            'status.*'      => 'The Status required and must be start or refused',
        ];
    }

    /**
     * 
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}


