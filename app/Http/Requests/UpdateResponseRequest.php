<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResponseRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you want to add authorization logic
    }

    public function rules()
    {
        return [
            'content' => 'required',
        ];
    }
}
