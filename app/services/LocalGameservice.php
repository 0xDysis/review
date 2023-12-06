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
                        // Add other fields as needed
                    ]
                );
            }
        }
    }
    public function getGamesQuery(Request $request)
{
    $query = LocalGame::query();

    // Filter by genre
    if ($request->filled('genre')) {
        $query->where('genre', 'like', '%' . $request->input('genre') . '%');
    }

    // Filter by publication year
    if ($request->filled('publication_year')) {
        $query->where('publication_year', '=', $request->input('publication_year'));
    }

    // Filter by average score
    if ($request->filled('average_score')) {
        $query->where('average_score', '>=', $request->input('average_score'));
    }

    // Sort by selected field
    if ($request->filled('sort_by')) {
        $sortField = $request->input('sort_by');
        $sortOrder = $request->input('sort_order', 'desc'); // Default to ascending order if not specified
        $query->whereNotNull($sortField)->orderBy($sortField, $sortOrder);
    }

    return $query;
}
}
