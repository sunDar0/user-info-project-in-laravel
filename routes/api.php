<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\UserController;

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

Route::post('/join', [UserController::class, 'join']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/users',[UserController::class, 'getUserList']);
Route::get('/users/{id}',[UserController::class, 'getUserDetail']);

Route::get('/users/{id}/orders',[UserController::class, 'getOrderListByUserId']);
