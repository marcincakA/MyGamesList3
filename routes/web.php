<?php

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
Route::post('/register', [UserHandlerController::class, 'register']);
Route::post('/logout', [UserHandlerController::class, 'logout']);
Route::post('/login', [UserHandlerController::class, 'login']);
Route::get('/editAccount/{userId}', [UserHandlerController::class, 'showEditScreen']);
Route::put('/editAccount/{userId}', [UserHandlerController::class, 'updateUser']);
Route::delete('/deleteAccount/{userId}', [UserHandlerController::class, 'deleteUser']);

