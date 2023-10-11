<?php

namespace Modules\Pegawai\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;
    protected $table= 'tb_jabatan';
    protected $fillable = ['nama_jabatan'];
    
    protected static function newFactory()
    {
        return \Modules\Pegawai\Database\factories\JabatanFactory::new();
    }
}
