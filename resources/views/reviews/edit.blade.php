@extends('layouts.app')

@section('content')
    <h1>Edit Review</h1>

    <form method="POST" action="{{ route('reviews.update', $review->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ $review->title }}" required>
        </div>

        <div class="form-group">
            <label for="score">Score</label>
            <input type="number" id="score" name="score" min="1" max="10" value="{{ $review->score }}" required>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" required>{{ $review->content }}</textarea>
        </div>

        <button type="submit">Update Review</button>
    </form>
@endsection
