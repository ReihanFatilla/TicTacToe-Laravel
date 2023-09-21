<?php

use App\Http\Controllers\TicTacToeController;
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

Route::group(['middleware' => 'check.device.token'], function () {
    Route::get('/tictactoe', [TicTacToeController::class, 'index']);
    Route::post('/tictactoe', [TicTacToeController::class, 'store']);
    Route::patch('/tictactoe/{id}', [TicTacToeController::class, 'update']);
    Route::delete('/tictactoe/{id}', [TicTacToeController::class, 'delete']);
});
