<?php


use App\Http\Controllers\Admin\PenempatanBarangController;

// Get Riwayat Penempatan Barang
Route::get("riwayat-penempatan-barang", [PenempatanBarangController::class, "getRiwayatPenempatanBarang"]);

// Get all barang
Route::get("barang-tetap", [PenempatanBarangController::class, "getAllBarang"]);

// Get All Barang Ruangan by id barang
Route::get("barang/{id_barang}/penempatan-barang", [PenempatanBarangController::class, "get"]);

// Get By ID
Route::get("penempatan-barang/{id}", [PenempatanBarangController::class, "getById"]);

// Insert
Route::post("barang/{id_barang}/penempatan-barang", [PenempatanBarangController::class, "create"]);

// Edit
Route::put("penempatan-barang/{id}", [PenempatanBarangController::class, "update"]);

// Delete
Route::delete("penempatan-barang/{id}", [PenempatanBarangController::class, "destroy"]);
