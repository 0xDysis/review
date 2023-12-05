@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('browse') }}">
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" class="form-control" value="{{ request('genre') }}">
            </div>

            <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" id="publication_year" name="publication_year" class="form-control" value="{{ request('publication_year') }}">
            </div>

            <div class="form-group">
                <label for="average_score">Average Score</label>
                <input type="number" id="average_score" name="average_score" class="form-control" value="{{ request('average_score') }}">
            </div>

            <div class="form-group">
                <label for="keyword">Keyword</label>
                <input type="text" id="keyword" name="keyword" class="form-control" value="{{ request('keyword') }}">
            </div>

            <div class="form-group">
                <label for="sort_by">Sort By</label>
                <select id="sort_by" name="sort_by" class="form-control">
                    <option value="name"{{ request('sort_by') == 'name' ? ' selected' : '' }}>Name</option>
                    <option value="publication_year"{{ request('sort_by') == 'publication_year' ? ' selected' : '' }}>Publication Year</option>
                    <option value="average_score"{{ request('sort_by') == 'average_score' ? ' selected' : '' }}>Average Score</option>
                    <option value="number_of_reviews"{{ request('sort_by') == 'number_of_reviews' ? ' selected' : '' }}>Number of Reviews</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        @foreach ($games as $game)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('games.show', $game) }}">{{ $game->name }}</a></h5>
                    <p class="card-text">{{ $game->genre }}</p>
                    <p class="card-text">{{ $game->publication_year }}</p>
                    <p class="card-text">{{ $game->average_score }}</p>
                    <p class="card-text">{{ $game->number_of_reviews }}</p>
                    <!-- Display other game data as needed -->
                </div>
            </div>
        @endforeach

        {{ $games->links() }}
    </div>
@endsection
