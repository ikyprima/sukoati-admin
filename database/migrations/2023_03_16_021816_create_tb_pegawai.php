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
        Schema::create('tb_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk_pegawai');
            $table->string('nama');
            $table->string('gelar_depan', 100);
            $table->string('gelar_belakang', 100);
            $table->text('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('photo');
            $table->bigInteger('id_agama');
            $table->bigInteger('id_jenis_kelamin');
            $table->bigInteger('id_jabatan');
            $table->bigInteger('id_pangkat');
            $table->bigInteger('id_user_create');
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
        Schema::dropIfExists('tb_pegawai');
    }
};
