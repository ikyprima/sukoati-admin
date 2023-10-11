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
        Schema::create('tb_pegawai_alamat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pegawai');
            $table->char('id_propinsi',2)->nullable();
            $table->char('id_kab_kot',4)->nullable();
            $table->char('id_kec',6)->nullable();
            $table->char('id_kel',10)->nullable();
            $table->char('rt',3)->nullable();
            $table->char('rw',3)->nullable();
            $table->text('alamat');
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
        Schema::dropIfExists('tb_pegawai_alamat');
    }
};
