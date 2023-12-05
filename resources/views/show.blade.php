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
    <form method="POST" action="{{ route('reviews.store') }}">
        @csrf
        <input type="hidden" name="game_id" value="{{ $game->id }}">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="score">Score</label>
            <input type="number" id="score" name="score" class="form-control">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
    @foreach ($game->reviews as $review)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $review->title }}</h5>
                <p class="card-text">Score: {{ $review->score }}</p>
                <p class="card-text">{{ $review->content }}</p>
                <p class="card-text">Reviewed by: {{ $review->user->name }}</p>

                @if (auth()->id() == $review->user_id)
                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-primary">Edit</a>

                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <form method="POST" action="{{ route('likes.store') }}">
                        @csrf
                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                        <button type="submit" class="btn btn-primary">Like</button>
                    </form>
                @endif

                @foreach ($review->responses as $response)
                    <div class="card mt-4">
                        <div class="card-body">
                            <p class="card-text">{{ $response->content }}</p>
                            <p class="card-text">Responded by: {{ $response->user->name }}</p>

                            @if (auth()->id() == $response->user_id)
                                <a href="{{ route('responses.edit', $response) }}" class="btn btn-primary">Edit</a>

                                <form method="POST" action="{{ route('responses.destroy', $response) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                <form method="POST" action="{{ route('responses.store') }}">
                    @csrf
                    <input type="hidden" name="review_id" value="{{ $review->id }}">
                    <div class="form-group">
                        <label for="content">Your Response</label>
                        <textarea id="content" name="content" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Response</button>
                </form>
            </div>
        </div>
    @endforeach
@endsection
