@extends('layouts.app')

@section('content')
@vite('resources/sass/users.scss')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <div class="banner">
                        <img src="{{ asset($user->banner) }}" alt="User Banner" class="img-fluid">
                    </div>
                    
                    <div class="profile-pic">
                        <img src="{{ asset($user->profile_pic) }}" alt="Profile Picture" class="rounded-circle">
                    </div>
                    <h2>{{ $user->name }}</h2>
                </div>

                <div class="card-body">
                    <h3>Review and Comment History</h3>
                    <div id="history">
                      <h4>Reviews</h4>
                      @foreach ($user->reviews as $review)
                          <div>
                              <a href="/games/{{ $review->game_id }}#review-{{ $review->id }}">
                                  <h5>{{ $review->title }}</h5>
                                  <p>{{ $review->content }}</p>
                              </a>
                          </div>
                      @endforeach
                      
                      <h4>Responses</h4>
                      @foreach ($user->responses as $response)
                          <div>
                              <a href="/games/{{ $response->review->game_id }}#response-{{ $response->id }}">
                                  <p>{{ $response->content }}</p>
                              </a>
                          </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection