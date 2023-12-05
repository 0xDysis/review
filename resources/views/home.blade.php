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
                    <h3>Favorites</h3>
                    <div id="favorites">
                        <!-- Display the user's favorite movies, books, or games here -->
                    </div>

                    <h3>Review and Comment History</h3>
                    <div id="history">
                        <!-- Display the user's review and comment history here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
