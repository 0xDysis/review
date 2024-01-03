<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
{
    // Use the validated data from the StoreReviewRequest
    $data = $request->validated();

    // Create a new Review using the validated data
    $review = Review::create([
        'user_id' => auth()->id(), // Get the authenticated user's ID
        'game_id' => $data['game_id'], // Use the validated data
        'title' => $data['title'], // Use the validated data
        'content' => $data['content'], // Use the validated data
        'score' => $data['score'], // Use the validated data
        'is_approved' => false, // Set as false by default
    ]);

    // Redirect back to the previous page
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
