<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RWPenempatanBarang extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = "rw_brg_ruangan";
}
