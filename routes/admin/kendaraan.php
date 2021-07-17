<?php


use App\Http\Controllers\Admin\KendaraanController;

// Get All Kendaraan
Route::get("kendaraan", [KendaraanController::class, "get"]);

// Get Kendaraan By ID
Route::get("kendaraan/{id}", [KendaraanController::class, "getById"]);

// Insert Kendaraan
Route::post("kendaraan", [KendaraanController::class, "create"]);

// Edit Kendaraan
Route::post("kendaraan/{id}", [KendaraanController::class, "update"]);

// Soft Delete Kendaraan
Route::delete("kendaraan-soft-delete/{id}", [KendaraanController::class, "softDelete"]);

// Restore Kendaraan By ID
Route::put("kendaraan-restore/{id}", [KendaraanController::class, "restoreById"]);

// Restore All Kendaraan
Route::put("kendaraan-restore", [KendaraanController::class, "restoreAll"]);

// Delete Permanent Kendaraan
Route::delete("kendaraan-permanent-delete/{id}", [KendaraanController::class, "permanentDelete"]);

// Delete Permanent All Kendaraan
Route::delete("kendaraan-permanent-delete", [KendaraanController::class, "permanentDeleteAll"]);

// Get Sampah Kendaraan
Route::get("kendaraan-sampah", [KendaraanController::class, "getTrash"]);

// Generate QR Code
Route::put("kendaraan-generate-qrcode/{id_kendaraan}", [KendaraanController::class, "generateQrCode"]);
