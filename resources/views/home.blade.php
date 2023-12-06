@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <img src="{{ Auth::user()->banner }}" alt="User Banner">
                    <img src="{{ Auth::user()->profile_pic }}" alt="Profile Picture">
                    <h2>{{ Auth::user()->name }}</h2>
                </div>

                <div class="card-body">
                    <h3>Update Profile</h3>
                    <form method="POST" action="{{ route('home.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
    <label for="current_password">Current Password (only if changing password)</label>
    <input id="current_password" type="password" name="current_password">
</div>

<div>
    <label for="new_password">New Password (only if changing password)</label>
    <input id="new_password" type="password" name="new_password">
</div>

<div>
    <label for="new_password_confirmation">Confirm New Password (only if changing password)</label>
    <input id="new_password_confirmation" type="password" name="new_password_confirmation">
</div>


                        <div>
                            <label for="profile_pic">Profile Picture</label>
                            <input id="profile_pic" type="file" name="profile_pic">
                        </div>

                        <div>
                            <label for="banner">Banner</label>
                            <input id="banner" type="file" name="banner">
                        </div>

                        <button type="submit">Update Profile</button>
                    </form>

                    <h3>Favorites</h3>
                    <div id="favorites">
                        <!-- Display the user's favorite movies, books, or games here -->
                    </div>

                    <h3>Review and Comment History</h3>
                    <div id="history">
                        <h4>Reviews</h4>
                        @foreach (Auth::user()->reviews as $review)
                            <div>
                                <h5>{{ $review->title }}</h5>
                                <p>{{ $review->content }}</p>
                            </div>
                        @endforeach

                        <h4>Responses</h4>
                        @foreach (Auth::user()->responses as $response)
                            <div>
                                <p>{{ $response->content }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

