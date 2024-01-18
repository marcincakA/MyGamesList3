<?php

use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\ListItemController;
use App\Http\Controllers\api\ReviewController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/games', GameController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/items', ListItemController::class);
Route::apiResource('/reviews', ReviewController::class);
Route::get('reviews/game/{gameId}', [ReviewController::class, 'reviewsForGame']);
