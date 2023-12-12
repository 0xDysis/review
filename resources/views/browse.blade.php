@extends('layouts.app')

@section('content')
@vite('resources/sass/browse.scss')
    <div class="container">
        <form method="GET" action="{{ route('browse') }}" class="search-form" id="search-form">
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="form-control" value="{{ old('search', request('search')) }}">
            </div>

            <div class="sort-container">
                <label for="sort_by">Sort By</label>
                <select id="sort_by" name="sort_by" onchange="this.form.submit()">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="publication_year" {{ request('sort_by') == 'publication_year' ? 'selected' : '' }}>Publication Year</option>
                    <option value="average_score" {{ request('sort_by') == 'average_score' ? 'selected' : '' }}>Average Score</option>
                    <option value="number_of_reviews" {{ request('sort_by') == 'number_of_reviews' ? 'selected' : '' }}>Number of Reviews</option>
                </select>
                <button type="submit" id="order-btn" name="sort_order" value="{{ request('sort_order', 'asc') == 'asc' ? 'desc' : 'asc' }}" class="order-btn">
                    <i id="order-icon" class="fas fa-arrow-{{ request('sort_order', 'asc') == 'asc' ? 'up' : 'down' }}"></i>
                </button>
            </div>
        </form>



        <div class="wrapper">
            @foreach ($games as $game)
                <a href="{{ route('games.show', $game) }}" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <div class="poster">
                            <img src="{{ $game->cover_image }}" alt="{{ $game->name }}">
                        </div>
                        <div class="details">
                            <h1>{{ $game->name }}</h1>
                            <h2>{{ $game->publication_year }} • {{ $game->genre }}</h2>
                            <div class="rating">
                                <!-- Replace with actual game rating -->
                                <i class="fas fa-chart-bar"></i>
                                
                                <span>{{ $game->average_score }}/100</span>
                            </div>
                            <p class="desc">
                                <!-- Replace with actual game description -->
                                {{ $game->description }}
                            </p>
                            <!-- Add other game data as needed -->
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{ $games->withQueryString()->links('vendor.pagination.custom-pagination') }}

    </div>
   



    


@endsection