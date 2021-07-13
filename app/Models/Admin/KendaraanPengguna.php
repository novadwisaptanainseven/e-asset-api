<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanPengguna extends Model
{
    use HasFactory;

    protected $table = "kendaraan_pengguna";
    protected $primaryKey = "id_kendaraan_pengguna";
}
