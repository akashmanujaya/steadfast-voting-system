<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\VoteController;
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

Route::middleware(['auth:sanctum', 'check_user_voted'])->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/vote', [VoteController::class, 'store'])->middleware('auth:sanctum');
});

