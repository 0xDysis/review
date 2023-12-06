<?php

namespace App\Services;

use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use Illuminate\Http\Request;

class IgdbService
{
    public function getGames($limit = 100)
    {
        $games = IgdbGame::select([
                'name',
                'genres.name',
                'first_release_date',
                'rating',
                'total_rating_count',
                'cover.url',
                'summary',
                'storyline',
                // Add other fields as needed
            ])
            ->with(['genres', 'cover'])
            ->limit($limit)
            ->get();

        return $games;
    }
}



