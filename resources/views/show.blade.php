@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $game->name }}</h5>
                <p class="card-text">Genre: {{ $game->genre }}</p>
                <p class="card-text">Publication Year: {{ $game->publication_year }}</p>
                <p class="card-text">Average Score: {{ $game->average_score }}</p>
                <p class="card-text">Number of Reviews: {{ $game->number_of_reviews }}</p>
                <p class="card-text">Summary: {{ $game->summary }}</p>
                <p class="card-text">Storyline: {{ $game->storyline }}</p>
                <!-- Display other game data as needed -->
            </div>
        </div>
        <a href="{{ route('browse') }}" class="btn btn-primary mt-3">Back to Browse</a>
    </div>
@endsection
