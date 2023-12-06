<?php

namespace App\Http\Controllers;

use App\Services\LocalGameService;
use Illuminate\Http\Request;
use App\Models\LocalGame; 

class BrowseController extends Controller
{
    private $localGameService;

    public function __construct(LocalGameService $localGameService)
    {
        $this->localGameService = $localGameService;
    }

    public function index(Request $request)
    {
        $games = $this->localGameService->getGamesQuery($request)->paginate(9);

        return view('browse', compact('games'));
    }
    public function show(LocalGame $game)
{
    return view('show', compact('game'));
}

}





