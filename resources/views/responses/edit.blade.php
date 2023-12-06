@extends('layouts.app')

@section('content')
    <h1>Edit Response</h1>

    <form method="POST" action="{{ route('responses.update', $response->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" required>{{ $response->content }}</textarea>
        </div>

        <button type="submit">Update Response</button>
    </form>
@endsection

    


