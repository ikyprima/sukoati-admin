<?php

namespace App\Models\Sukoati;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kotum extends Model
{
    use HasFactory;
    protected $table = 'kota';
    
    protected $fillable = ['nama'];
}