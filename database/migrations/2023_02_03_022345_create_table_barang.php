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
        Schema::create('table_barang', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('nama');
            $table->string('barcode');
            $table->string('merk');
            $table->integer('stok_min');
            $table->bigInteger('id_kategori');
            $table->bigInteger('id_satuan');
            $table->string('photo');
            $table->text('keterangan');
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
        Schema::dropIfExists('table_barang');
    }
};
