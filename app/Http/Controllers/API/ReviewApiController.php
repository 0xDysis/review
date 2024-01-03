<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use App\Http\Resources\ReviewAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Get all reviews with related user and game data
        $reviews = Review::with(['user', 'localGame'])->get();

        // Transform the reviews using the ReviewAPI resource and return them as a response
        return ReviewAPI::collection($reviews);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\ReviewAPI
     */
    public function show($id)
    {
        // Get the review by ID with related user and game data
        $review = Review::with(['user', 'localGame'])->find($id);
    
        // If the review does not exist, return a 404 response
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
    
        // Transform the review using the ReviewAPI resource and return it as a response
        return new ReviewAPI($review);
    }
}
