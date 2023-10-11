<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'tb_satuan';
    protected $fillable = ['nama','singkatan'];
    
    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\SatuanFactory::new();
    }
}
