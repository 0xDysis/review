<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalGame extends Model
{
    use HasFactory;

    protected $table = 'games'; // Specify the actual name of your table

    protected $fillable = [
        'name',
        'genre',
        'publication_year',
        'average_score',
        'number_of_reviews',
        'cover_image',
        'summary',
        'storyline',
        // Add other fields as needed
    ];
}



