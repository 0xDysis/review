@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    <p>Welcome, {{ Auth::user()->name }}! You are logged in as an admin.</p>

                    <!-- Add admin dashboard content here -->
                    <p>Here, you can manage users, reviews, and other admin tasks.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

