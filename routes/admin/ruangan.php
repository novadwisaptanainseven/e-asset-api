<?php

// Get All Ruangan

use App\Http\Controllers\Admin\RuanganController;

Route::get("ruangan", [RuanganController::class, "get"]);

// Get Ruangan By ID
Route::get("ruangan/{id}", [RuanganController::class, "getById"]);

// Insert Ruangan
Route::post("ruangan", [RuanganController::class, "create"]);

// Edit Ruangan
Route::put("ruangan/{id}", [RuanganController::class, "update"]);

// Delete Ruangan
Route::delete("ruangan/{id}", [RuanganController::class, "destroy"]);
