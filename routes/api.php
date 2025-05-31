<?php

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

Route::get('/message', function () {
    return response()->json(['message' => 'Hello from Laravel!']);
});

Route::prefix('author')->namespace('App\Http\Controllers')->group(function () {
    Route::get('index', 'AuthorController@index');
    Route::get('show/{id}', 'AuthorController@show');
    Route::post('store', 'AuthorController@store');
    Route::put('update/{id}', 'AuthorController@update');
    Route::delete('delete/{id}', 'AuthorController@delete');
});

Route::prefix('book')->namespace('App\Http\Controllers')->group(function () {
    Route::get('index', 'BookController@index');
    Route::get('show/{id}', 'BookController@show');
    Route::post('store', 'BookController@store');
    Route::put('update/{id}', 'BookController@update');
    Route::delete('delete/{id}', 'BookController@delete');
});