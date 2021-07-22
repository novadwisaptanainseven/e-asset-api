<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use App\Models\Admin\PenempatanBarang;
use App\Models\Admin\RWPenempatanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenempatanBarangController extends Controller
{
    protected $PenempatanBarangModel;
    protected $tbl_barang = "barang";
    protected $tbl_kategori = "kategori";
    protected $tbl_ruangan = "ruangan";
    protected $tbl_riwayat = "rw_brg_ruangan";

    public function __construct()
    {
        $this->PenempatanBarangModel = new PenempatanBarang();
    }

    // Get Riwayat Penempatan Barang
    public function getRiwayatPenempatanBarang() {
        $riwayat = RWPenempatanBarang::select(
            "$this->tbl_riwayat.*",
            "$this->tbl_barang.nama_barang",
            "$this->tbl_barang.merk",
            "$this->tbl_ruangan.nama_ruangan",
        )
        ->join($this->tbl_barang, "$this->tbl_barang.id_barang", "=", "$this->tbl_riwayat.id_barang")
        ->join($this->tbl_ruangan, "$this->tbl_ruangan.id_ruangan", "=", "$this->tbl_riwayat.id_ruangan")
        ->orderByDesc("$this->tbl_riwayat.created_at")
        ->get();

        foreach($riwayat as $i => $r) {
            $r->no = $i + 1;
        }

        return response()->json([
            "message" => "Berhasil mendapatkan data riwayat penempatan barang",
            "data" => $riwayat
        ], 200);
    }

    // Get All Barang 
    public function getAllBarang()
    {
        // Get data barang
        $barang = Barang::select("$this->tbl_barang.*", "$this->tbl_kategori.nama_kategori")
                ->join("$this->tbl_kategori", "$this->tbl_kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
                ->orderBy("$this->tbl_barang.created_at", "DESC")
                ->where("jenis_barang", "tetap")
                ->get();

        foreach($barang as $i => $b) {
            $baik_terpakai = $this->PenempatanBarangModel->getBarangTerpakai($b->id_barang);
            $baik_tidak_terpakai = $b->jumlah_baik - $baik_terpakai;

            $b->no = $i + 1;
            $b->jumlah_baik_terpakai = intval($baik_terpakai);
            $b->jumlah_baik_tidak_terpakai = $baik_tidak_terpakai;
        }

        return response()->json([
            "message" => "Berhasil mendapatkan semua data barang",
            "data" => $barang
        ], 200);
    }

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
        $baik_terpakai = $this->PenempatanBarangModel->getBarangTerpakai($id_barang);
        // $baik_terpakai = PenempatanBarang::where("id_barang", $id_barang)
        //     ->sum("jumlah");
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
            ["barang_ruangan.id_barang", "=", $id_barang],
            ["barang_ruangan.id_ruangan", "=", $req->id_ruangan],
        ])
            ->join("ruangan", "ruangan.id_ruangan", "=", "barang_ruangan.id_ruangan")
            ->first();
        if ($ruangan_sama) {
            return response()->json([
                "errors" => "Barang sudah ada di ruangan $ruangan_sama->nama_ruangan, jika ada pembaruan jumlah penempatan di ruangan tersebut, maka hanya lakukan update pada data barang yang bersangkutan"
            ], 400);
        }

        // Cek sisa barang tidak terpakai
        $data_barang = Barang::find($id_barang);
        $baik_terpakai = $this->PenempatanBarangModel->getBarangTerpakai($id_barang);
        $baik_tidak_terpakai = $data_barang->jumlah_baik - $baik_terpakai;
        if ($req->jumlah > $baik_tidak_terpakai) {
            return response()->json([
                "errors" => "Jumlah barang yang ditempatkan melebihi stok barang"
            ], 400);
        }

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

        // Insert Riwayat penempatan barang
        RWPenempatanBarang::create([
            "penginput" => $user->name,
            "aktivitas" => "Ditambahkan",
            "id_ruangan" => $req->id_ruangan,
            "id_barang" => $id_barang,
            "jumlah" => $req->jumlah,
            "tgl_penempatan" => $req->tgl_penempatan,
            "keterangan" => $req->keterangan,
        ]);

        return response()->json([
            "message" => "Berhasil menambahkan data barang ruangan dengan id barang: $id_barang",
            "input_data" => $input
        ], 201);
    }

    // Update Barang Ruangan by ID
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

        // Insert Riwayat penempatan barang
        RWPenempatanBarang::create([
            "penginput"      => $user->name,
            "aktivitas"      => "Diupdate",
            "id_ruangan"     => $req->id_ruangan,
            "id_barang"      => $barang_ruangan->id_barang,
            "jumlah"         => $req->jumlah,
            "tgl_penempatan" => $barang_ruangan->tgl_penempatan,
            "tgl_update"     => $req->tgl_update,
            "keterangan"     => $req->keterangan,
        ]);

        return response()->json([
            "message" => "Berhasil memperbarui data barang ruangan dengan id barang ruangan: $id",
            "input_data" => $input
        ], 201);
    }

    // Delete Barang Ruangan by ID
    public function destroy($id)
    {
        $user = Auth::user();

        $barang_ruangan = PenempatanBarang::find($id);
        if ($barang_ruangan) {

            $barang_ruangan->delete();

            // Insert Riwayat penempatan barang
            RWPenempatanBarang::create([
            "penginput"      => $user->name,
            "aktivitas"      => "Dihapus",
            "id_ruangan"     => $barang_ruangan->id_ruangan,
            "id_barang"      => $barang_ruangan->id_barang,
            "jumlah"         => $barang_ruangan->jumlah,
            "tgl_penempatan" => $barang_ruangan->tgl_penempatan,
            "tgl_update"     => $barang_ruangan->tgl_update,
            "tgl_hapus"      => date("Y-m-d"),
            "keterangan"     => $barang_ruangan->keterangan,
        ]);

            return response()->json([
                "message" => "Berhasil menghapus data barang ruangan dengan id: $id",
                "data_deleted" => $barang_ruangan
            ], 201);
        } else {
            return response()->json([
                "message" => "Data barang ruangan dengan id: $id tidak ditemukan",
            ], 404);
        }
    }
}
