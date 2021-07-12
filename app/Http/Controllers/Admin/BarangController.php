<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Barang;
use Illuminate\Http\Request;
use App\Models\Admin\BarangPengguna;
use Illuminate\Support\Facades\Http;

class BarangController extends Controller
{
    protected $tbl_barang = "barang";
    // Get All Barang
    public function get()
    {
        // Get data barang
        $data = Barang::join("kategori", "kategori.id_kategori", "=", "$this->tbl_barang.id_kategori")
            ->orderBy("$this->tbl_barang.created_at", "DESC")
            ->get();

        // Get data pegawai from e-pekerja
        $pegawai = Http::get(config('url_api_epekerja') . "pegawai/1")->json()["data"];

        foreach ($data as $i => $d) {
            $d->no = $i + 1;
            $d->pengguna = BarangPengguna::where("id_barang", $d->id_barang)->orderByDesc("id_barang_pengguna")->first();
        }



        // $data = Barang::find(2)->pengguna;

        return response()->json([
            "message" => "Berhasil mendapatkan semua data barang",
            "data" => $pegawai,
        ], 200);
    }
}
