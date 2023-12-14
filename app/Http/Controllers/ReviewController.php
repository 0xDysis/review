<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'user_id' => auth()->id(),
            'game_id' => $request->game_id,
            'title' => $request->title,
            'content' => $request->content,
            'score' => $request->score,
            'is_approved' => false,
        ]);

        return back();
    }

    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return redirect()->route('games.show', $review->game_id);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back();
    }

    public function show(Review $review)
    {
        return view('show', compact('review'));
    }
}
