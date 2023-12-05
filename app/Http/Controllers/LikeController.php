<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $like = new Like;
        $like->user_id = auth()->id();
        $like->review_id = $request->review_id;
        $like->save();

        return back();
    }
}

