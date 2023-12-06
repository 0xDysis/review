<?php
namespace App\Services;

use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use Illuminate\Http\Request;

class IgdbService
{
    public function getGames($limit = 1000)
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
            ->whereNotNull('cover.url') // Only fetch games with a cover image
            ->orderBy('total_rating_count', 'desc') // Order by total_rating_count in descending order
            ->limit($limit)
            ->get();
    
        return $games;
    }
}



