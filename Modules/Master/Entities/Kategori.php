<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'tb_kategori';
    protected $fillable = ['nama','singkatan'];
    
    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\KategoriFactory::new();
    }
}
