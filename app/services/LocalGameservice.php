<?php

namespace App\Services;

use App\Models\LocalGame;
use Illuminate\Http\Request;

class LocalGameService
{
    public function storeGames($games)
    {
        foreach ($games as $gameData) {
            if (isset($gameData->name)) {
                $genre = $gameData->genres ? $gameData->genres->pluck('name')->join(', ') : null;
                $publication_year = $gameData->first_release_date ? $gameData->first_release_date->format('Y') : null;
                LocalGame::updateOrCreate(
                    ['name' => $gameData->name],
                    [
                        'genre' => $genre,
                        'publication_year' => $publication_year,
                        'average_score' => $gameData->rating,
                        'number_of_reviews' => $gameData->total_rating_count,
                        'cover_image' => $gameData->cover->url ?? null,
                        'summary' => $gameData->summary,
                        'storyline' => $gameData->storyline,
                        
                    ]
                );
            }
        }
    }

    public function getGamesQuery(Request $request, $search = null)
    {
        $query = LocalGame::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('genre', 'LIKE', '%' . $search . '%')
                ->orWhere('publication_year', 'LIKE', '%' . $search . '%')
                ->orWhere('average_score', 'LIKE', '%' . $search . '%');
        }

        // Other filters...

        if ($request->filled('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order if not specified
            $query->whereNotNull($sortField)->orderBy($sortField, $sortOrder);
        }

        return $query;
}
}