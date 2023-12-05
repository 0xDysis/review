<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\ReviewController; 
use App\Http\Controllers\ResponseController; 
use App\Http\Controllers\LikeController; 



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
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::post('/responses', [ResponseController::class, 'store'])->name('responses.store')->middleware('auth');
Route::get('/responses/{response}/edit', [ResponseController::class, 'edit'])->name('responses.edit')->middleware('auth');
Route::put('/responses/{response}', [ResponseController::class, 'update'])->name('responses.update')->middleware('auth');
Route::delete('/responses/{response}', [ResponseController::class, 'destroy'])->name('responses.destroy')->middleware('auth');
Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit')->middleware('auth');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update')->middleware('auth');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');
Route::post('/likes', [LikeController::class, 'store'])->name('likes.store')->middleware('auth');








