<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Http\Requests\StoreResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Notifications\ResponseSubmitted;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::where(function ($query) {
            $query->where('is_approved', true)
                  ->orWhere('user_id', auth()->id());
        })->get();

        return view('responses.index', compact('responses'));
    }

    public function store(StoreResponseRequest $request)
{
    if (!auth()->check()) {
        return redirect('login'); 
    }

    $response = Response::create([
        'user_id' => auth()->id(),
        'review_id' => $request->review_id,
        'content' => $request->content,
        'is_approved' => false,
    ]);

    
    $review = $response->review;
    $review->user->notify(new ResponseSubmitted($response));

    return back();
}

   

    public function update(UpdateResponseRequest $request, Response $response)
    {
        $response->update($request->validated());
    
        return redirect()->route('games.show', $response->review->game_id);
    }

    public function edit(Response $response)
    {
        return view('responses.edit', compact('response'));
    }

    public function destroy(Response $response)
    {
        $response->delete();

        return back();
    }
    public function show(Response $response)
{
    return view('show', compact('response'));
}
}

