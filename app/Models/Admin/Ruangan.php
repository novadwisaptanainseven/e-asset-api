<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_ruangan',
        'user_created',
        'user_updated',
    ];

    protected $table = "ruangan";
    protected $primaryKey = "id_ruangan";
}
