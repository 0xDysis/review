<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController; // Add this line
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\BrowseController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    // This route is now only for regular users
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home'); // Update this line
    // Add other routes that require a verified email here
});

Route::get('/verify', function () {
    return view('auth.verify');
})->middleware('auth');

// New admin dashboard route
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', DashboardController::class)->name('admin.dashboard');
    // Add other routes that require admin access here
});

Route::get('/oauth/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');

Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/games/{game}', [BrowseController::class, 'show'])->name('games.show');








