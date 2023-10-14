<?php

namespace Modules\Barang\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MBarang extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table= 'table_barang';
    protected static function newFactory()
    {
        return \Modules\Barang\Database\factories\MBarangFactory::new();
    }
}
