<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MenuItem extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "menu_items";
    protected $with = ["children"];
    protected $dates = ['deleted_at'];
    protected $fillable = ["id_parent","is_parent","is_allow_drag","id_menu","title","url","name_route","icon"];
    protected $hidden = [
        'updated_at','deleted_at','created_at','id_menu'
    ];

    public function children(){
        return $this->hasMany(Self::class, "id_parent", "id");
    }
    public function parent(){
        return $this->belongsTo(Self::class, "id_parent", "id")->with('parent')->without('children');
        // return $this->belongsTo("App\Model\mRuangan", "parent_id", "id")->with('parent');
    }


    public function menu(){
        return $this->hasOne('App\Models\Menu','id','id_menu');
    }

    public function permission(){
        return $this->hasMany('App\Models\MenuHasPermission','id_menu','id');
    }
    public function role(){
        return $this->hasMany('App\Models\MenuHasRole','id_menu','id');
    }
    
}
