<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHasRole extends Model
{
    use HasFactory;
    protected $table= "menu_has_roles";
    public function menuItem(){
        return $this->hasOne('App\Models\MenuItem','id','id_menu');
    }
}
