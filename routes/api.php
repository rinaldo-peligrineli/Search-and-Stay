<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BooksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/bookstore/book/store', [BookSController::class, 'store']);
Route::group(['prefix' => 'users'], function () {
    Route::get('/list', [UsersController::class, 'index']);
    Route::post('/store', [UsersController::class, 'store']);

});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::get('auth/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'bookstore'], function () {
        Route::group(['prefix' => 'book'], function () {
            Route::get('/list', [BookSController::class, 'index']);
            Route::get('/edit/{id}', [BookSController::class, 'edit']);

            Route::put('/update/{id}', [BookSController::class, 'update']);
            Route::delete('/delete/{id}', [BookSController::class, 'destroy']);

        });

    });

});
