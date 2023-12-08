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
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'name'); // Default to 'name' if not provided
        $sort_order = $request->input('sort_order', 'asc'); // Default to 'asc' if not provided
    
        $games = $this->localGameService->getGamesQuery($request, $search)->orderBy($sort_by, $sort_order)->paginate(9);
    
        return view('browse', compact('games'));
    }

    public function show(LocalGame $game)
    {
        return view('show', compact('game'));
    }
}










