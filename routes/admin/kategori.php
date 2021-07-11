<?php

// Get All Kategori

use App\Http\Controllers\Admin\KategoriController;

// Get All Kategori
Route::get("kategori", [KategoriController::class, "get"]);

// Get Kategori By ID
Route::get("kategori/{id}", [KategoriController::class, "getById"]);

// Insert Kategori
Route::post("kategori", [KategoriController::class, "create"]);

// Edit Kategori
Route::put("kategori/{id}", [KategoriController::class, "update"]);

// Delete Kategori
Route::delete("kategori/{id}", [KategoriController::class, "destroy"]);
