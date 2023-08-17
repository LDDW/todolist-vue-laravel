<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
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

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {

    // UserController
    Route::get('user', [UserController::class, 'index']);
    Route::put('user/account', [UserController::class, 'updateUser']);
    Route::put('user/password', [UserController::class, 'updatePassword']);
    Route::delete('user', [UserController::class, 'destroy']);

    // AuthController
    Route::post('logout', [AuthController::class, 'logout']);

    // TodoController
    Route::get('todo', [TodoController::class, 'index']);
    Route::post('todo', [TodoController::class, 'store']);
    Route::get('todo/{id}', [TodoController::class, 'show']);
    Route::put('todo/{id}', [TodoController::class, 'update']);
    Route::delete('todo/{id}', [TodoController::class, 'destroy']);

    // DashboardController
    Route::get('dashboard', [DashbaordController::class, 'index']);

});