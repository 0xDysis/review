<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'score' => 'required|integer|between:1,10',
            'content' => 'required',
        ]);

        $review = new Review;
        $review->user_id = auth()->id();
        $review->game_id = $request->game_id;
        $review->title = $request->title;
        $review->score = $request->score;
        $review->content = $request->content;
        $review->save();

        return redirect()->route('games.show', $request->game_id);
    }
    public function edit(Review $review)
{
    return view('reviews.edit', compact('review'));
}

public function update(Request $request, Review $review)
{
    $request->validate([
        'title' => 'required|max:255',
        'score' => 'required|integer|between:1,10',
        'content' => 'required',
    ]);

    $review->title = $request->title;
    $review->score = $request->score;
    $review->content = $request->content;
    $review->save();

    return redirect()->route('games.show', $review->game_id);
}

public function destroy(Review $review)
{
    $review->delete();

    return back();
}

}

