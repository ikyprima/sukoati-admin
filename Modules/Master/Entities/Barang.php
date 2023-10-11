<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Satuan;
use Modules\Master\Entities\Kategori;
class Barang extends Model
{
    use HasFactory;
    protected $table= 'table_barang';
    protected $fillable = ['sku','nama','barcode','stok_min','id_kategori','id_satuan','keterangan','photo'];
    
    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\BarangFactory::new();
    }

    public function kategori() {
        return $this->hasOne(Kategori::class,'id','id_kategori');
    }
    public function satuan() {
        return $this->hasOne(Satuan::class,'id','id_satuan');
    }
}
