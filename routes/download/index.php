<?php

// Image

use App\Http\Controllers\FileController;

// Get Image
Route::get('image/{filename}', [FileController::class, "getImage"]);

// Get Document
Route::get('document/{filename}', [FileController::class, "getDocument"]);

// Get Qr Code
Route::get('qr-code/{filename}', [FileController::class, "getQrCode"]);
