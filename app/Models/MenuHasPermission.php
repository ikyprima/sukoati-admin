<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHasPermission extends Model
{

    use HasFactory;
    protected $table= 'menu_has_permissions';
    protected $fillable = ['id_menu','id_permissions',"ket"];
    public function menuItem(){
        return $this->hasOne('App\Models\MenuItem','id','id_menu')->whereNull('deleted_at');
    }
}
