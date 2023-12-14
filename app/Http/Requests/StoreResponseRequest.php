<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResponseRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you want to add authorization logic
    }

    public function rules()
    {
        return [
            'content' => 'required',
            'review_id' => 'required|exists:reviews,id',
        ];
    }
}