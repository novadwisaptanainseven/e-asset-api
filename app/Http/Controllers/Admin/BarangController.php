<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use Illuminate\Http\Request;
use App\Models\Admin\BarangPengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    protected $tbl_barang = "barang";
    protected $tbl_kategori = "kategori";
    // Get All Barang
    public function get(Request $req)
    {
        if ($req->jenis_barang) {
            $data = Barang::select("$this->tbl_barang.*", "$this->tbl_kategori.nama_kategori")
                ->join("$this->tbl_kategori", "$this->tbl_kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
                ->orderBy("$this->tbl_barang.created_at", "DESC")
                ->where("jenis_barang", $req->jenis_barang)
                ->get();
        } elseif ($req->kategori) {
            $data = Barang::select("$this->tbl_barang.*", "$this->tbl_kategori.nama_kategori")
                ->join("$this->tbl_kategori", "$this->tbl_kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
                ->orderBy("$this->tbl_barang.created_at", "DESC")
                ->where("$this->tbl_barang.id_kategori", $req->kategori)
                ->get();
        } else {
            // Get data barang
            $data = Barang::select("$this->tbl_barang.*", "$this->tbl_kategori.nama_kategori")
                ->join("$this->tbl_kategori", "$this->tbl_kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
                ->orderBy("$this->tbl_barang.created_at", "DESC")
                ->get();
        }

        foreach ($data as $i => $d) {
            $d->no = $i + 1;
        }

        return response()->json([
            "message" => "Berhasil mendapatkan semua data barang",
            "data" => $data,
        ], 200);
    }

    // Get Barang By ID
    public function getById($id)
    {
        // Get data barang by id
        $barang = Barang::select("$this->tbl_barang.*", "$this->tbl_kategori.nama_kategori")
            ->join("$this->tbl_kategori", "$this->tbl_kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
            ->where("$this->tbl_barang.id_barang", $id)
            ->first();

        // Jika barang tidak ditemukan
        if (!$barang) {
            return response()->json([
                "message" => "Data barang dengan id: $id tidak ditemukan",
            ], 404);
        }

        // Get pengguna barang
        $pengguna = BarangPengguna::where("id_barang", $barang->id_barang)->get();

        // Get pegawai from api epekerja by id pegawai of barang pengguna table
        foreach ($pengguna as $i => $p) {
            $p->no = 1 + $i;
            $p->pegawai = Http::get(config('url_api_epekerja') . "pegawai/$p->id_pegawai")->json()["data"];
        }

        $barang->pengguna = $pengguna;

        return response()->json([
            "message" => "Berhasil mendapatkan data barang dengan id: $id",
            "data" => $barang
        ], 200);
    }

    // Insert Barang
    public function create(Request $req)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "kode_barang"     => "required",
                "nama_barang"     => "required",
                "jenis_barang"    => "required",
                "id_kategori"     => "required",
                "tahun_pembelian" => "required",
                "merk"            => "required",
                "no_pabrik"       => "required",
                "ukuran"          => "required",
                "bahan"           => "required",
                "harga"           => "required",
                "jumlah_baik"     => "required",
                "jumlah_rusak"    => "required",
                "jumlah_barang"   => "required",
                "satuan"          => "required",
                "keterangan"      => "required",
                "file"            => "mimes:pdf|max:5048",
                "foto"            => "mimes:jpg,jpeg,png|max:5048",
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

        // Cek apakah ada file foto
        if (!$req->file('foto')) {
            $foto = '';
        } else {
            $file = $req->file("foto");

            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $foto = $file->storeAs("images", rand(0, 9999) . time() . '-' . $sanitize);
        }

        // Cek apakah ada file 
        if (!$req->file('file')) {
            $file = '';
        } else {
            $file = $req->file("file");

            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $file = $file->storeAs("documents", rand(0, 9999) . time() . '-' . $sanitize);
        }

        // Insert data 
        $input_data = [
            "kode_barang"     => $req->kode_barang,
            "nama_barang"     => $req->nama_barang,
            "jenis_barang"    => $req->jenis_barang,
            "id_kategori"     => $req->id_kategori,
            "tahun_pembelian" => $req->tahun_pembelian,
            "merk"            => $req->merk,
            "no_pabrik"       => $req->no_pabrik,
            "ukuran"          => $req->ukuran,
            "bahan"           => $req->bahan,
            "harga"           => $req->harga,
            "jumlah_baik"     => $req->jumlah_baik,
            "jumlah_rusak"    => $req->jumlah_rusak,
            "jumlah_barang"   => $req->jumlah_barang,
            "satuan"          => $req->satuan,
            "keterangan"      => $req->keterangan,
            "file"            => $file,
            "foto"            => $foto,
            "user_created"    => $user->name,
            "user_updated"    => $user->name,
        ];
        $barang = Barang::create($input_data);

        return response()->json([
            "message" => "Berhasil menambahkan data barang",
            "input_data" => $input_data
        ], 201);
    }

    // Edit Barang
    public function update(Request $req, $id)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "kode_barang"     => "required",
                "nama_barang"     => "required",
                "jenis_barang"    => "required",
                "id_kategori"     => "required",
                "tahun_pembelian" => "required",
                "merk"            => "required",
                "no_pabrik"       => "required",
                "ukuran"          => "required",
                "bahan"           => "required",
                "harga"           => "required",
                "jumlah_baik"     => "required",
                "jumlah_rusak"    => "required",
                "jumlah_barang"   => "required",
                "satuan"          => "required",
                "keterangan"      => "required",
                "file"            => "mimes:pdf|max:5048",
                "foto"            => "mimes:jpg,jpeg,png|max:5048",
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

        // Get data barang by id
        $barang = Barang::find($id);

        // Cek apakah ada file foto
        if (!$req->file('foto')) {
            $foto = $barang->foto;
        } else {
            // Delete foto lama
            $path_foto = $barang->foto;
            Storage::delete($path_foto);

            $file = $req->file("foto");

            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $foto = $file->storeAs("images", rand(0, 9999) . time() . '-' . $sanitize);
        }

        // Cek apakah ada file 
        if (!$req->file('file')) {
            $file = $barang->file;
        } else {
            // Delete file lama
            $path_file = $barang->file;
            Storage::delete($path_file);

            $file = $req->file("file");

            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $file = $file->storeAs("documents", rand(0, 9999) . time() . '-' . $sanitize);
        }

        // Edit data 
        $barang->kode_barang = $req->kode_barang ? $req->kode_barang : $barang->kode_barang;
        $barang->nama_barang = $req->nama_barang ? $req->nama_barang : $barang->nama_barang;
        $barang->jenis_barang = $req->jenis_barang ? $req->jenis_barang : $barang->jenis_barang;
        $barang->id_kategori = $req->id_kategori ? $req->id_kategori : $barang->id_kategori;
        $barang->tahun_pembelian = $req->tahun_pembelian ? $req->tahun_pembelian : $barang->tahun_pembelian;
        $barang->merk = $req->merk ? $req->merk : $barang->merk;
        $barang->no_pabrik = $req->no_pabrik ? $req->no_pabrik : $barang->no_pabrik;
        $barang->ukuran = $req->ukuran ? $req->ukuran : $barang->ukuran;
        $barang->bahan = $req->bahan ? $req->bahan : $barang->bahan;
        $barang->harga = $req->harga ? $req->harga : $barang->harga;
        $barang->jumlah_baik = $req->jumlah_baik ? $req->jumlah_baik : $barang->jumlah_baik;
        $barang->jumlah_rusak = $req->jumlah_rusak ? $req->jumlah_rusak : $barang->jumlah_rusak;
        $barang->jumlah_barang = $req->jumlah_barang ? $req->jumlah_barang : $barang->jumlah_barang;
        $barang->satuan = $req->satuan ? $req->satuan : $barang->satuan;
        $barang->keterangan = $req->keterangan ? $req->keterangan : $barang->keterangan;
        $barang->file = $file ? $file : $barang->file;
        $barang->foto = $foto ? $foto : $barang->foto;
        $barang->user_updated = $user->name;
        $barang->save();

        return response()->json([
            "message" => "Berhasil mengubah data barang dengan id: $id",
            "edit_data" => $barang
        ], 201);
    }

    // Permanent Delete Barang
    public function permanentDelete($id)
    {
        $barang = Barang::withTrashed()->where("id_barang", $id)->first();
        if ($barang) {
            $barang->forceDelete();
            // Delete file dan foto
            Storage::delete($barang->foto);
            Storage::delete($barang->file);

            return response()->json([
                "message" => "Berhasil menghapus data barang dengan id: $id secara permanent",
                "data_deleted" => $barang
            ], 201);
        } else {
            return response()->json([
                "message" => "Data barang dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Permanent Delete All Barang
    public function permanentDeleteAll()
    {
        $barang = Barang::onlyTrashed()->get();

        foreach ($barang as $k) {
            Barang::onlyTrashed()->where("id_barang", $k->id_barang)->forceDelete();

            // Delete file dan foto
            Storage::delete($k->foto);
            Storage::delete($k->file);
        }

        return response()->json([
            "message" => "Berhasil menghapus semua sampah data barang secara permanent",
            "data_deleted" => $barang
        ], 201);
    }

    // Soft Delete Barang
    public function softDelete($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            // Hapus foto dan file barang
            // Storage::delete($barang->foto);
            // Storage::delete($barang->file);

            $barang->delete();

            return response()->json([
                "message" => "Berhasil menghapus data barang (soft delete) dengan id: $id",
                "data_deleted" => $barang
            ], 201);
        } else {
            return response()->json([
                "message" => "Data barang dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Restore Barang By ID
    public function restoreById($id)
    {
        $barang = Barang::withTrashed()->where("id_barang", $id);
        if ($barang->restore()) {
            return response()->json([
                "message" => "Berhasil memulihkan (restore) data barang dengan id: $id",
                "data_restored" => $barang->get()
            ], 201);
        } else {
            return response()->json([
                "message" => "Data barang dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Restore All Barang
    public function restoreAll()
    {
        // Get data sampah
        $barang_sampah = Barang::onlyTrashed()->get();
        Barang::withTrashed()->restore();

        return response()->json([
            "message" => "Berhasil memulihkan (restore) semua data barang",
            "data_restored" => $barang_sampah
        ], 201);
    }

    // Get Sampah Barang
    public function getTrash()
    {
        $barang_sampah = Barang::onlyTrashed()
        ->join("$this->tbl_kategori", "$this->tbl_kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
        ->orderBy("$this->tbl_barang.deleted_at", "DESC")    
        ->get();

        foreach($barang_sampah as $i => $barang) {
            $barang->no = $i + 1;
        }

        return response()->json([
            "message" => "Berhasil mendapatkan semua sampah data barang",
            "data_trash" => $barang_sampah
        ], 200);
    }

    // Generate QR Code
    public function generateQrCode($id_barang)
    {
        $barang = Barang::find($id_barang);
        if ($barang) {
            // Jika barang ditemukan

            // Generate QR Code
            $qrCodeName = rand(0, 9999) . time() . "qr-code-$id_barang.png";
            QrCode::size(250)
                ->format('png')
                // ->generate(config('url_api_easset') . "cek-barang/$id_barang", storage_path("app/qrCodes/$qrCodeName"));
                ->generate("https://disperkim.samarindakota.go.id/epekerja", storage_path("app/qrCodes/$qrCodeName"));

            // Save to database tabel barang
            Barang::where("id_barang", $id_barang)->update(["qr_code" => $qrCodeName]);

            return response()->json([
                "data" => "Generate QR Code Barang Berhasil"
            ], 201);
        } else {
            return response()->json([
                "message" => "Data barang dengan id: $id_barang tidak ditemukan",
            ], 404);
        }
    }
}
