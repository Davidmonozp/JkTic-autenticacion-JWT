<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas publicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rutas privadas Users
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//Rutas privadas Tasks
Route::middleware('auth:api')->group(function () {
    Route::post('/addTask', [TaskController::class, 'addTask']);
    Route::get('/tasks', [TaskController::class, 'getTasks']);
    Route::get('/tasks/{id}', [TaskController::class, 'getTaskById']);
    Route::put('/tasks/{id}', [TaskController::class, 'updateTaskById']);
    Route::delete('/tasks/{id}', [TaskController::class, 'deleteTaskById']);
});
