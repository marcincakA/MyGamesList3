<?php

use App\Http\Controllers\GameHandlerController;
use App\Http\Controllers\ListItemHandlerController;
use App\Http\Controllers\UserHandlerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//userHandler
Route::post('/register', [UserHandlerController::class, 'register']);
Route::post('/logout', [UserHandlerController::class, 'logout']);
Route::get('/showLogin', function () {
    return view('login');
});
Route::get('/showRegister', function () {
    return view('register');
});
Route::post('/login', [UserHandlerController::class, 'login']);
Route::get('/editAccount/{userId}', [UserHandlerController::class, 'showEditScreen']);
Route::put('/editAccount/{userId}', [UserHandlerController::class, 'updateUser']);
Route::delete('/deleteAccount/{userId}', [UserHandlerController::class, 'deleteUser']);
//gameHandler
Route::get('/add_game', [GameHandlerController::class, 'redirect_to_addGame']);
Route::post('/addGame', [GameHandlerController::class, 'add_Game']);
Route::get('/viewGames', [GameHandlerController::class, 'viewGames']);
Route::delete('delete_game/{game}', [GameHandlerController::class, 'deleteGame']);
Route::get('/edit_game/{game}', [GameHandlerController::class, 'showEditScreen']);
Route::put('/edit_game/{game}', [GameHandlerController::class, 'updateGame']);
Route::get('viewGames/{id}/{title}', [GameHandlerController::class, 'showGamePage']);
//reviews
Route::post('/createReview/{game}/{user}', []);
//mylist
Route::get('myList/{userId}', [ListItemHandlerController::class, 'showMyList']);
