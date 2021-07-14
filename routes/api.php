<?php

use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\AuthController;
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

// API LEVEL ADMIN
Route::prefix('admin/')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // All Secure URL's
        Route::group(['middleware' => 'is_admin'], function () {
            include_once __DIR__ . "/admin/index.php";
        });
    });
});

// API Download
include_once __DIR__ . "/download/index.php";

// Authentication
include_once __DIR__ . '/auth/index.php';
