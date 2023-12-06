<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
{
    // Get the search query from the request
    $query = $request->input('query');

    // Search the games table for game names that match the query
    $searchResults = DB::table('games')
        ->where('name', 'like', '%' . $query . '%')
        ->get();

    // Return the search results as a JSON response
    return response()->json($searchResults);
}

}


