<?php

namespace App\Http\Requests;

class ContactRequest extends Request
{

    public function rules()
    {
        return [
            'name'         => 'required',
            'email'        => 'required|email',
            'phone_number' => '',
            'message'      => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
