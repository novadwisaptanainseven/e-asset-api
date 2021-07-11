<?php 


use App\Http\Controllers\AuthController;

// Login User
Route::post('login', [AuthController::class, "login"]);

// Register User
Route::post('register', [AuthController::class, "register"]);

// Cek User
Route::middleware('auth:sanctum')->get('user', [AuthController::class, "me"]);

// Logout
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, "logout"]);