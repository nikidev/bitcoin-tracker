<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns',
            'price_limit' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    public function messages()
    {
        return  [
            'price_limit.regex' => 'The price limit format is invalid. Example: 48000.55'
        ];
    }
}
