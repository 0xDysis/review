@extends('layouts.app')

@section('content')
@vite('resources/sass/browse.scss')
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

        <div class="wrapper">
            @foreach ($games as $game)
                <div class="card">
                    <div class="poster">
                    <img src="{{ $game->cover_image }}" alt="{{ $game->name }}">


                    </div>
                    <div class="details">
                        <h1><a href="{{ route('games.show', $game) }}">{{ $game->name }}</a></h1>
                        <h2>{{ $game->publication_year }} • {{ $game->genre }}</h2>
                        <div class="rating">
                            <!-- Replace with actual game rating -->
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>{{ $game->average_score }}/5</span>
                        </div>
                        <p class="desc">
                            <!-- Replace with actual game description -->
                            {{ $game->description }}
                        </p>
                        <!-- Add other game data as needed -->
                    </div>
                </div>
            @endforeach
        </div>

        {{ $games->withQueryString()->links('vendor.pagination.custom-pagination') }}

    </div>
@endsection
