<?php

namespace App\Models\Admin;

use App\Models\Admin\Kategori;
use App\Models\Admin\BarangPengguna;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = "barang";
    protected $primaryKey = "id_barang";

    public function pengguna()
    {
        return $this->hasMany(BarangPengguna::class, "id_barang", "id_barang");
    }
}
