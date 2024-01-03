<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReviewApiController;
use App\Http\Controllers\API\ApiKeyController;  // Add this line

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

Route::middleware('checkBearerToken')->get('/reviews', [ReviewApiController::class, 'index']);
Route::middleware('checkBearerToken')->get('/reviews/{id}', [ReviewApiController::class, 'show']);





Route::post('/api-keys', [ApiKeyController::class, 'createApiKey']);  // Add this line
