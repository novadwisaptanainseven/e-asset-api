<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenempatanBarang extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "barang_ruangan";
    protected $primaryKey = "id_barang_ruangan";
}
