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
            $table->string('sku')->nullable();
            $table->string('nama');
            $table->string('barcode')->nullable();
            $table->string('merk')->nullable();
            $table->integer('stok_min')->nullable();
            $table->bigInteger('id_kategori');
            $table->bigInteger('id_satuan');
            $table->string('photo')->nullable();
            $table->text('keterangan')->nullable();
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
