<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPengguna extends Model
{
    use HasFactory;

    protected $table = "barang_pengguna";
    protected $primaryKey = "id_barang_pengguna";

    public function barang()
    {
        return $this->belongsTo(Barang::class, "id_barang");
    }
}
