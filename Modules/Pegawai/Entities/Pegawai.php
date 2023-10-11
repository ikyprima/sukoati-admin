<?php

namespace Modules\Pegawai\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Entities\Pangkat;
use Modules\Pegawai\Entities\Jabatan;
use Modules\Pegawai\Entities\Pendidikan;

class Pegawai extends Model
{
    use HasFactory;
    protected $table= 'tb_pegawai';
    protected $fillable = ['nik','nama','jekel','id_jabatan','id_pangkat','id_pendidikan'];
    
    protected static function newFactory()
    {
        return \Modules\Pegawai\Database\factories\PegawaiFactory::new();
    }
    public function pangkat() {
        return $this->hasOne(Pangkat::class,'id','id_pangkat');
    }
    public function jabatan() {
        return $this->hasOne(Jabatan::class,'id','id_jabatan');
    }
    public function pendidikan() {
        return $this->hasOne(Pendidikan::class,'id','id_pendidikan');
    }
}
