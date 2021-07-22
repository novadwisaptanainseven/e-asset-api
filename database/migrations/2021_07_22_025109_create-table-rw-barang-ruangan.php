<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRwBarangRuangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rw_brg_ruangan', function (Blueprint $table) {
            $table->id();
            $table->string("penginput", 100);
            $table->string("aktivitas", 30);
            $table->integer("id_ruangan")->index();
            $table->integer("id_barang")->index();
            $table->integer("jumlah");
            $table->date("tgl_penempatan");
            $table->date("tgl_update");
            $table->text("keterangan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rw_brg_ruangan');
    }
}
