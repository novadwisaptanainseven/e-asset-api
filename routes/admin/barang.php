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
Route::post("barang/{id}", [BarangController::class, "update"]);

// Soft Delete Barang
Route::delete("barang-soft-delete/{id}", [BarangController::class, "softDelete"]);

// Restore Barang By ID
Route::put("barang-restore/{id}", [BarangController::class, "restoreById"]);

// Restore All Barang
Route::put("barang-restore", [BarangController::class, "restoreAll"]);

// Delete Permanent Barang
Route::delete("barang-permanent-delete/{id}", [BarangController::class, "permanentDelete"]);

// Delete Permanent All Barang
Route::delete("barang-permanent-delete", [BarangController::class, "permanentDeleteAll"]);

// Get Sampah Barang
Route::get("barang-sampah", [BarangController::class, "getTrash"]);

// Generate QR Code
Route::put("barang-generate-qrcode/{id_barang}", [BarangController::class, "generateQrCode"]);
