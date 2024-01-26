<?php

namespace App\Models\Sukoati;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biodatum extends Model
{
    use HasFactory;
    protected $table = 'biodata';
    
    protected $fillable = ['nama', 'alamat', 'tgl_lahir'];
}