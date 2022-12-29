<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table= 'menu';
    protected $fillable = [];
    public function menuItem(){
        return $this->hasMany('App\Models\MenuItem','id_menu','id');
    }
}
