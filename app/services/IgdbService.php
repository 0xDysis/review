<?php
namespace App\Services;

use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use MarcReichel\IGDBLaravel\Enums\Image\Size;
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
                'cover.image_id',
                'summary',
                'storyline',
                // Add other fields as needed
            ])
            ->with(['genres', 'cover'])
            ->whereNotNull('cover.image_id') // Only fetch games with a cover image
            ->orderBy('total_rating_count', 'desc') // Order by total_rating_count in descending order
            ->limit($limit)
            ->get();

        // Replace the cover image with a high-quality version
        foreach ($games as $game) {
            if ($game->cover) {
                $game->cover->url = $game->cover->getUrl(Size::COVER_BIG, true);
            }
        }
    
        return $games;
    }
}



