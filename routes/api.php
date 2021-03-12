<?php

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

Route::get('/todos/{id}', 'App\Http\Controllers\TodoController@show');
Route::post('/todos', 'App\Http\Controllers\TodoController@create');
Route::put('/todos/{id}', 'App\Http\Controllers\TodoController@update');
Route::delete('/todos/{id}', 'App\Http\Controllers\TodoController@delete');
