<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Kendaraan;
use App\Models\Admin\KendaraanPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    protected $tbl_kendaraan = "kendaraan";

    // Get All Kendaraan
    public function get()
    {
        // Get data kendaraan
        $data = Kendaraan::orderByDesc("created_at")->get();

        // Get data pegawai from e-pekerja
        $pegawai = Http::get(config('url_api_epekerja') . "pegawai/1")->json()["data"];

        foreach ($data as $i => $d) {
            $d->no = $i + 1;
            $pengguna = KendaraanPengguna::where("id_kendaraan", $d->id_kendaraan)->orderByDesc("created_at")->first();
            if ($pengguna) {
                // Dapatkan data pegawai dari api epekerja
                $d->pengguna = Http::get(config('url_api_epekerja') . "pegawai/$pengguna->id_pegawai")->json()["data"];
            } else {
                $d->pengguna = null;
            }
        }

        return response()->json([
            "message" => "Berhasil mendapatkan semua data kendaraan",
            "data" => $data,
        ], 200);
    }

    // Get Kendaraan By ID
    public function getById($id)
    {
        // Get data kendaraan by id
        $kendaraan = Kendaraan::find($id);

        // Jika kendaraan tidak ditemukan
        if (!$kendaraan) {
            return response()->json([
                "message" => "Data kendaraan dengan id: $id tidak ditemukan",
            ], 404);
        }

        // Get pengguna kendaraan
        $pengguna = KendaraanPengguna::where("id_kendaraan", $kendaraan->id_kendaraan)->get();

        // Get pegawai from api epekerja by id pegawai of kendaraan pengguna table
        foreach ($pengguna as $i => $p) {
            $p->no = 1 + $i;
            $p->pegawai = Http::get(config('url_api_epekerja') . "pegawai/$p->id_pegawai")->json()["data"];
        }

        $kendaraan->pengguna = $pengguna;

        return response()->json([
            "message" => "Berhasil mendapatkan data kendaraan dengan id: $id",
            "data" => $kendaraan
        ], 200);
    }

    // Insert Kendaraan
    public function create(Request $req)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "kode_kendaraan"  => "required",
                "jenis_kendaraan" => "required",
                "merk"            => "required",
                "tipe"            => "required",
                "cc"              => "required",
                "bahan"           => "required",
                "warna"           => "required",
                "no_rangka"       => "required",
                "no_pabrik"       => "required",
                "no_mesin"        => "required",
                "no_polisi"       => "required",
                "tahun_pembuatan" => "required",
                "tahun_pembelian" => "required",
                "bpkb"            => "required",
                "stnk"            => "required",
                "harga"           => "required",
                "biaya_stnk"      => "required",
                "kondisi"         => "required",
                "asal_usul"       => "required",
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
            "kode_kendaraan"  => $req->kode_kendaraan,
            "jenis_kendaraan" => $req->jenis_kendaraan,
            "merk"            => $req->merk,
            "tipe"            => $req->tipe,
            "cc"              => $req->cc,
            "bahan"           => $req->bahan,
            "warna"           => $req->warna,
            "no_rangka"       => $req->no_rangka,
            "no_pabrik"       => $req->no_pabrik,
            "no_mesin"        => $req->no_mesin,
            "no_polisi"       => $req->no_polisi,
            "tahun_pembuatan" => $req->tahun_pembuatan,
            "tahun_pembelian" => $req->tahun_pembelian,
            "bpkb"            => $req->bpkb,
            "stnk"            => $req->stnk,
            "harga"           => $req->harga,
            "biaya_stnk"      => $req->biaya_stnk,
            "kondisi"         => $req->kondisi,
            "asal_usul"       => $req->asal_usul,
            "keterangan"      => $req->keterangan,
            "file"            => $file,
            "foto"            => $foto,
            "user_created"    => $user->name,
            "user_updated"    => $user->name,
        ];
        $kendaraan = Kendaraan::create($input_data);

        return response()->json([
            "message" => "Berhasil menambahkan data kendaraan",
            "input_data" => $input_data
        ], 201);
    }

    // Edit Kendaraan
    public function update(Request $req, $id)
    {
        $user = Auth::user();

        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $req->all(),
            [
                "kode_kendaraan"  => "required",
                "jenis_kendaraan" => "required",
                "merk"            => "required",
                "tipe"            => "required",
                "cc"              => "required",
                "bahan"           => "required",
                "warna"           => "required",
                "no_rangka"       => "required",
                "no_pabrik"       => "required",
                "no_mesin"        => "required",
                "no_polisi"       => "required",
                "tahun_pembuatan" => "required",
                "tahun_pembelian" => "required",
                "bpkb"            => "required",
                "stnk"            => "required",
                "harga"           => "required",
                "biaya_stnk"      => "required",
                "kondisi"         => "required",
                "asal_usul"       => "required",
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

        // Get data kendaraan by id
        $kendaraan = Kendaraan::find($id);
        // Jika data kendaraan tidak ditemukan
        if (!$kendaraan) {
            return response()->json([
                "message" => "Data kendaraan dengan id: $id tidak ditemukan",
            ], 404);
        }

        // Cek apakah ada file foto
        if (!$req->file('foto')) {
            $foto = $kendaraan->foto;
        } else {
            // Delete foto lama
            $path_foto = $kendaraan->foto;
            Storage::delete($path_foto);

            $file = $req->file("foto");

            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $foto = $file->storeAs("images", rand(0, 9999) . time() . '-' . $sanitize);
        }

        // Cek apakah ada file 
        if (!$req->file('file')) {
            $file = $kendaraan->file;
        } else {
            // Delete file lama
            $path_file = $kendaraan->file;
            Storage::delete($path_file);

            $file = $req->file("file");

            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $file = $file->storeAs("documents", rand(0, 9999) . time() . '-' . $sanitize);
        }

        // Edit data 
        $kendaraan->kode_kendaraan = $req->kode_kendaraan ? $req->kode_kendaraan : $kendaraan->kode_kendaraan;
        $kendaraan->jenis_kendaraan = $req->jenis_kendaraan ? $req->jenis_kendaraan : $kendaraan->jenis_kendaraan;
        $kendaraan->merk = $req->merk ? $req->merk : $kendaraan->merk;
        $kendaraan->tipe = $req->tipe ? $req->tipe : $kendaraan->tipe;
        $kendaraan->cc = $req->cc ? $req->cc : $kendaraan->cc;
        $kendaraan->bahan = $req->bahan ? $req->bahan : $kendaraan->bahan;
        $kendaraan->warna = $req->warna ? $req->warna : $kendaraan->warna;
        $kendaraan->no_rangka = $req->no_rangka ? $req->no_rangka : $kendaraan->no_rangka;
        $kendaraan->no_pabrik = $req->no_pabrik ? $req->no_pabrik : $kendaraan->no_pabrik;
        $kendaraan->no_mesin = $req->no_mesin ? $req->no_mesin : $kendaraan->no_mesin;
        $kendaraan->no_polisi = $req->no_polisi ? $req->no_polisi : $kendaraan->no_polisi;
        $kendaraan->tahun_pembuatan = $req->tahun_pembuatan ? $req->tahun_pembuatan : $kendaraan->tahun_pembuatan;
        $kendaraan->tahun_pembelian = $req->tahun_pembelian ? $req->tahun_pembelian : $kendaraan->tahun_pembelian;
        $kendaraan->bpkb = $req->bpkb ? $req->bpkb : $kendaraan->bpkb;
        $kendaraan->stnk = $req->stnk ? $req->stnk : $kendaraan->stnk;
        $kendaraan->harga = $req->harga ? $req->harga : $kendaraan->harga;
        $kendaraan->biaya_stnk = $req->biaya_stnk ? $req->biaya_stnk : $kendaraan->biaya_stnk;
        $kendaraan->kondisi = $req->kondisi ? $req->kondisi : $kendaraan->kondisi;
        $kendaraan->asal_usul = $req->asal_usul ? $req->asal_usul : $kendaraan->asal_usul;
        $kendaraan->keterangan = $req->keterangan ? $req->keterangan : $kendaraan->keterangan;
        $kendaraan->file = $file ? $file : $kendaraan->file;
        $kendaraan->foto = $foto ? $foto : $kendaraan->foto;
        $kendaraan->user_updated = $user->name;
        $kendaraan->save();

        return response()->json([
            "message" => "Berhasil mengubah data kendaraan dengan id: $id",
            "edit_data" => $kendaraan
        ], 201);
    }

    // Permanent Delete Kendaraan
    public function permanentDelete($id)
    {
        $kendaraan = Kendaraan::withTrashed()->where("id_kendaraan", $id)->first();
        if ($kendaraan) {
            $kendaraan->forceDelete();
            // Delete file dan foto
            Storage::delete($kendaraan->foto);
            Storage::delete($kendaraan->file);

            return response()->json([
                "message" => "Berhasil menghapus data kendaraan dengan id: $id secara permanent",
                "data_deleted" => $kendaraan
            ], 201);
        } else {
            return response()->json([
                "message" => "Data kendaraan dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Permanent Delete All Kendaraan
    public function permanentDeleteAll()
    {
        $kendaraan = Kendaraan::onlyTrashed()->get();

        foreach ($kendaraan as $k) {
            Kendaraan::onlyTrashed()->where("id_kendaraan", $k->id_kendaraan)->forceDelete();

            // Delete file dan foto
            Storage::delete($k->foto);
            Storage::delete($k->file);
        }

        return response()->json([
            "message" => "Berhasil menghapus semua sampah data kendaraan secara permanent",
            "data_deleted" => $kendaraan
        ], 201);
    }

    // Soft Delete Kendaraan
    public function softDelete($id)
    {
        $kendaraan = Kendaraan::find($id);
        if ($kendaraan) {
            // Hapus foto dan file kendaraan
            // Storage::delete($kendaraan->foto);
            // Storage::delete($kendaraan->file);

            $kendaraan->delete();

            return response()->json([
                "message" => "Berhasil menghapus data kendaraan (soft delete) dengan id: $id",
                "data_deleted" => $kendaraan
            ], 201);
        } else {
            return response()->json([
                "message" => "Data kendaraan dengan id: $id tidak ditemukan",
            ], 404);
        }
    }


    // Restore Kendaraan By ID
    public function restoreById($id)
    {
        $kendaraan = Kendaraan::withTrashed()->where("id_kendaraan", $id);
        if ($kendaraan->restore()) {
            return response()->json([
                "message" => "Berhasil memulihkan (restore) data kendaraan dengan id: $id",
                "data_restored" => $kendaraan->get()
            ], 201);
        } else {
            return response()->json([
                "message" => "Data kendaraan dengan id: $id tidak ditemukan",
            ], 404);
        }
    }

    // Restore All Kendaraan
    public function restoreAll()
    {
        // Get data sampah
        $kendaraan_sampah = Kendaraan::onlyTrashed()->get();
        Kendaraan::withTrashed()->restore();

        return response()->json([
            "message" => "Berhasil memulihkan (restore) semua data kendaraan",
            "data_restored" => $kendaraan_sampah
        ], 201);
    }

    // Get Sampah Kendaraan
    public function getTrash()
    {
        $kendaraan_sampah = Kendaraan::onlyTrashed()->get();

        return response()->json([
            "message" => "Berhasil mendapatkan semua sampah data kendaraan",
            "data_trash" => $kendaraan_sampah
        ], 200);
    }
}
