<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::get('photos-estudio', [PhotoController::class, 'estudioPhotos']);
Route::get('photos-exterior', [PhotoController::class, 'exteriorPhotos']);
Route::post('store-message', [MessageController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::get('users', [UserController::class, 'index']);
    Route::put('update-profile', [UserController::class, 'update']);
    Route::delete('delete-acount/{id}', [AuthController::class, 'destroy']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('photos', [PhotoController::class, 'index']);
    Route::post('store-photo', [PhotoController::class, 'store']);
    Route::get('show-photo/{id}', [PhotoController::class, 'show']);
    Route::post('update-photo', [PhotoController::class, 'update']);
    Route::delete('delete-photo/{id}', [PhotoController::class, 'destroy']);
    Route::get('messages', [MessageController::class, 'index']);
    Route::get('show-message/{id}', [MessageController::class, 'show']);
    Route::delete('delete-message/{id}', [MessageController::class, 'destroy']);
});

