<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use App\Notifications\ResponseSubmitted;


class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        $response = new Response;
        $response->user_id = auth()->id();
        $response->review_id = $request->review_id;
        $response->content = $request->content;
        $response->save();
    
        // Send notification
        $review = $response->review;
        $review->user->notify(new ResponseSubmitted($response));
    
        return back();
    }
    public function edit(Response $response)
    {
        return view('responses.edit', compact('response'));
    }
    
    public function update(Request $request, Response $response)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        $response->content = $request->content;
        $response->save();
    
        return redirect()->route('games.show', $response->review->game_id);
    }
    
    public function destroy(Response $response)
    {
        $response->delete();
    
        return back();
    }
        
    

}

