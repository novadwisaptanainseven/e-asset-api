<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // Get All Kategori
    public function get()
    {
        $data = Kategori::orderBy("created_at", "DESC")->get();

        return response()->json([
            "message" => "Berhasil mendapatkan semua data kategori",
            "data" => $data
        ], 200);
    }

    // Get Kategori By ID
    public function getById($id)
    {
        $data = Kategori::find($id);

        if ($data) {
            return response()->json([
                "message" => "Berhasil mendapatkan data kategori dengan id: $id",
                "data" => $data
            ], 200);
        } else {
            return response()->json([
                "message" => "Data kategori dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Insert Kategori
    public function create(Request $req)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "nama_kategori" => "required"
            ],
            $message
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // Jika validasi berhasil
        // Insert data 
        $input_data = [
            "nama_kategori" => $req->nama_kategori,
            "user_created"  => $user->name,
            "user_updated"  => $user->name,
        ];
        $kategori = Kategori::create($input_data);

        return response()->json([
            "message" => "Berhasil menambahkan data kategori",
            "input_data" => $input_data
        ], 201);
    }

    // Edit Kategori
    public function update(Request $req, $id)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "nama_kategori" => "required"
            ],
            $message
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // Jika validasi berhasil
        // Edit data 
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                "message" => "Data kategori dengan id: $id tidak ditemukan",
            ], 404);
        }
        $kategori->nama_kategori = $req->nama_kategori ? $req->nama_kategori : $kategori->nama_kategori;
        $kategori->user_updated = $user->name;
        $kategori->save();

        return response()->json([
            "message" => "Berhasil mengubah data kategori dengan id: $id",
            "data_updated" => $kategori
        ], 201);
    }

    // Delete Kategori
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();

            return response()->json([
                "message" => "Berhasil menghapus data kategori dengan id: $id",
                "data_deleted" => $kategori
            ], 201);
        } else {
            return response()->json([
                "message" => "Data kategori dengan id: $id tidak ditemukan",
            ], 404);
        }
    }
}
