<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use App\Models\Admin\PenempatanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenempatanBarangController extends Controller
{
    // Get All Daftar Barang Ruangan by ID Barang
    public function get($id_barang)
    {
        // Get data barang
        $data_barang = Barang::find($id_barang);

        if (!$data_barang) {
            return response()->json([
                "message" => "Data barang dengan id: $id_barang, tidak ditemukan"
            ], 404);
        }

        // Get data barang ruangan
        $data_barang_ruangan = PenempatanBarang::where("id_barang", $id_barang)
            ->join("ruangan", "ruangan.id_ruangan", "=", "barang_ruangan.id_ruangan")
            ->orderBy("barang_ruangan.created_at", "DESC")
            ->get();

        // Get total terpakai dan tidak terpakai
        $baik_terpakai = PenempatanBarang::where("id_barang", $id_barang)
            ->sum("jumlah");
        $baik_tidak_terpakai = $data_barang->jumlah_baik - $baik_terpakai;

        $output = [
            "jumlah_baik_terpakai" => intval($baik_terpakai),
            "jumlah_baik_tidak_terpakai" => $baik_tidak_terpakai,
            "jumlah_rusak_tidak_terpakai" => $data_barang->jumlah_rusak,
            "jumlah_barang" => $data_barang->jumlah_barang,
            "barang" => $data_barang,
            "barang_ruangan" => $data_barang_ruangan
        ];

        return response()->json([
            "message" => "Berhasil mendapatkan data barang ruangan dengan id barang: $id_barang",
            "data" => $output
        ], 200);
    }

    // Get Barang Ruangan By ID
    public function getById($id)
    {
        $barang_ruangan = PenempatanBarang::where("id_barang_ruangan", $id)
            ->join("ruangan", "ruangan.id_ruangan", "=", "barang_ruangan.id_ruangan")
            ->first();

        if ($barang_ruangan) {
            return response()->json([
                "message" => "Berhasil mendapatkan barang ruangan dengan id: $id",
                "data" => $barang_ruangan
            ], 200);
        } else {
            return response()->json([
                "message" => "Data barang ruangan dengan id: $id, tidak ditemukan"
            ], 404);
        }
    }

    // Insert Barang Ruangan by ID Barang
    public function create(Request $req, $id_barang)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];

        $validator = Validator::make(
            $req->all(),
            [
                "id_ruangan"     => "required",
                "jumlah"         => "required",
                "tgl_penempatan" => "required",
                "keterangan"     => "required",
            ],
            $message
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // Cek apakah ada ruangan yang sama, jika ada maka tampilkan response error, karena setiap ruangan hanya diwakili oleh satu jenis/merk barang, maka barang yang sudah ada tidak dapat diinputkan ke dalam ruangan yang sama 
        $ruangan_sama = PenempatanBarang::where([
            ["id_barang", "=", $id_barang],
            ["id_ruangan", "=", $req->id_ruangan],
        ])->first();
        if ($ruangan_sama) {
            return response()->json([
                "errors" => "Barang sudah ada di ruangan dengan id: $req->id_ruangan, jika ada pembaruan jumlah penempatan di ruangan tersebut, maka hanya lakukan update pada data barang yang bersangkutan"
            ], 400);
        }

        // Cek sisa barang
        $data_barang = Barang::find($id_barang);
        if ($req->jumlah > $data_barang->jumlah_baik) {
            return response()->json([
                "errors" => "Jumlah barang yang ditempatkan melebihi stok barang"
            ], 400);
        }

        // Pengurangan Stok Barang
        // $sisa_stok_barang_baik = $data_barang->jumlah_baik - $req->jumlah;
        // $sisa_stok_total_barang = $sisa_stok_barang_baik + $data_barang->jumlah_rusak;

        // Insert data
        $input = [
            "id_barang"      => $id_barang,
            "id_ruangan"     => $req->id_ruangan,
            "jumlah"         => $req->jumlah,
            "keterangan"     => $req->keterangan,
            "tgl_penempatan" => $req->tgl_penempatan,
            "user_created"   => $user->name,
            "user_updated"   => $user->name,
        ];
        $insert = PenempatanBarang::create($input);

        // // Update stok barang di tabel barang
        // Barang::where("id_barang", $id_barang)->update([
        //     "jumlah_baik" => $sisa_stok_barang_baik,
        //     "jumlah_barang" => $sisa_stok_total_barang
        // ]);

        return response()->json([
            "message" => "Berhasil menambahkan data barang ruangan dengan id barang: $id_barang",
            "input_data" => $input
        ], 201);
    }

    // Update Barang Ruangan by ID Barang
    public function update(Request $req, $id)
    {
        // Cek apakah data ditemukan
        $barang_ruangan = PenempatanBarang::find($id);
        if (!$barang_ruangan) {
            return response()->json([
                "message" => "Data barang ruangan dengan id: $id, tidak ditemukan"
            ], 404);
        }

        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];

        $validator = Validator::make(
            $req->all(),
            [
                "id_ruangan"  => "required",
                "jumlah"      => "required",
                "tgl_update"  => "required",
                "keterangan"  => "required",
                "jumlah_baik" => "required"
            ],
            $message
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // Cek sisa barang
        $data_barang = Barang::find($barang_ruangan->id_barang);
        if ($req->jumlah > $data_barang->jumlah_baik) {
            return response()->json([
                "errors" => "Jumlah barang yang ditempatkan melebihi stok barang"
            ], 400);
        }

        // Pengurangan Stok Barang
        // $sisa_stok_barang_baik = $req->jumlah_baik;

        // Update data
        $input = [
            "id_ruangan"   => $req->id_ruangan ? $req->id_ruangan : $barang_ruangan->id_ruangan,
            "jumlah"       => $req->jumlah ? $req->jumlah : $barang_ruangan->jumlah,
            "keterangan"   => $req->keterangan ? $req->keterangan : $barang_ruangan->keterangan,
            "tgl_update"   => $req->tgl_update ? $req->tgl_update : $barang_ruangan->tgl_update,
            "user_updated" => $user->name,
        ];
        $update = PenempatanBarang::where("id_barang_ruangan", $id)->update($input);

        // // Update stok barang di tabel barang
        // Barang::where("id_barang", $barang_ruangan->id_barang)->update([
        //     "jumlah_baik" => $sisa_stok_barang_baik,
        // ]);

        return response()->json([
            "message" => "Berhasil memperbarui data barang ruangan dengan id barang ruangan: $id",
            "input_data" => $input
        ], 201);
    }
}
