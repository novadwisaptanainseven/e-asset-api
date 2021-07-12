<?php

// Get All Kategori

use App\Http\Controllers\Admin\BarangController;

// Get All Barang
Route::get("barang", [BarangController::class, "get"]);

// Get Barang By ID
Route::get("barang/{id}", [BarangController::class, "getById"]);

// Insert Barang
Route::post("barang", [BarangController::class, "create"]);

// Edit Barang
Route::put("barang/{id}", [BarangController::class, "update"]);

// Delete Barang
Route::delete("barang/{id}", [BarangController::class, "destroy"]);
