<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255', 
            'content' => 'required|min:1|max:1000', 
            'score' => 'required|integer|between:1,100',
            'game_id' => 'required|exists:games,id',
        ];
    }
}