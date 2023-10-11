<?php

namespace Modules\Pegawai\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendidikan extends Model
{
    use HasFactory;
    protected $table= 'tb_pendidikan';
    protected $fillable = ['nama_pendidikan'];
    
    protected static function newFactory()
    {
        return \Modules\Pegawai\Database\factories\PendidikanFactory::new();
    }
}
