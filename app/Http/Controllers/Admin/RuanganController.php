<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kategori;
use App\Models\Admin\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    // Get All Ruangan
    public function get()
    {
        $data = Ruangan::orderBy("created_at", "DESC")->get();

        foreach($data as $i => $d) {
            $d->no = $i + 1;
        }

        return response()->json([
            "message" => "Berhasil mendapatkan semua data ruangan",
            "data" => $data
        ], 200);
    }

    // Get Ruangan By ID
    public function getById($id)
    {
        $data = Ruangan::find($id);

        if ($data) {
            return response()->json([
                "message" => "Berhasil mendapatkan data ruangan dengan id: $id",
                "data" => $data
            ], 200);
        } else {
            return response()->json([
                "message" => "Data ruangan dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Insert Ruangan
    public function create(Request $req)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "nama_ruangan" => "required"
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
            "nama_ruangan"  => $req->nama_ruangan,
            "user_created"  => $user->name,
            "user_updated"  => $user->name,
        ];
        $ruangan = Ruangan::create($input_data);

        return response()->json([
            "message" => "Berhasil menambahkan data ruangan",
            "input_data" => $input_data
        ], 201);
    }

    // Edit Ruangan
    public function update(Request $req, $id)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "nama_ruangan" => "required"
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
        $ruangan = Ruangan::find($id);
        if (!$ruangan) {
            return response()->json([
                "message" => "Data ruangan dengan id: $id tidak ditemukan",
            ], 404);
        }
        $ruangan->nama_ruangan = $req->nama_ruangan ? $req->nama_ruangan : $ruangan->nama_ruangan;
        $ruangan->user_updated = $user->name;
        $ruangan->save();

        return response()->json([
            "message" => "Berhasil mengubah data ruangan dengan id: $id",
            "data_updated" => $ruangan
        ], 201);
    }

    // Delete Ruangan
    public function destroy($id)
    {
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->delete();

            return response()->json([
                "message" => "Berhasil menghapus data ruangan dengan id: $id",
                "data_deleted" => $ruangan
            ], 201);
        } else {
            return response()->json([
                "message" => "Data ruangan dengan id: $id tidak ditemukan",
            ], 404);
        }
    }
}
