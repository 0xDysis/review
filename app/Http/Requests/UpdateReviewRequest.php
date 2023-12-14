<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255', // Title should not be longer than 255 characters
            'score' => 'required|integer|between:1,100',
            'content' => 'required|min:50|max:1000', // Content should be between 50 and 1000 characters
        ];
    }
}