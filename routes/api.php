<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewApiController;
use App\Http\Controllers\ApiKeyController;  // Add this line

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('client:api')->get('/reviews', [ReviewApiController::class, 'index']);
Route::middleware('client:api')->get('/reviews/{id}', [ReviewApiController::class, 'show']);


Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return response()->json(['message' => 'Logged in successfully']);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
});

Route::post('/api-keys', [ApiKeyController::class, 'createApiKey']);  // Add this line
