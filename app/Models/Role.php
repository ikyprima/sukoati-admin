<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
class Role extends SpatieRole
{
    use HasFactory;

    // protected $appends = ['menurole'];

    public function getMenuroleAttribute()
        {
            return $this->hasMany('App\Models\MenuHasRole', 'id_roles', 'id')->with('menuItem.menu')->get();
        }
}
