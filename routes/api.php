<?php

use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\GameListItemController;
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
//Route::get('games', [GameController::class, 'index']);
Route::apiResource('/users', UserController::class);
//Route::apiResource('/gamelistitems', GameListItemController::class);
Route::get('/gamelistitems/{gamelistitem}', [GameListItemController::class, 'show']);
