<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pegawai_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pegawai');
            $table->bigInteger('id_pendidikan');
            $table->string('nama');
            $table->string('kota')->nullable();
            $table->string('jurusan')->nullable();
            $table->date('thn_masuk')->nullable();
            $table->date('thn_keluar')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('tb_pegawai_pendidikan');
    }
};
