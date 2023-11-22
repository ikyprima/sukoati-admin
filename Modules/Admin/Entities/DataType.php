<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Facades\Admin;


class DataType extends Model
{

    protected $table = 'data_types';

    protected $fillable = [
        'name',
        'slug',
        'display_name_singular',
        'display_name_plural',
        'icon',
        'model_name',
        'policy_name',
        'controller',
        'description',
        'generate_permissions',
        'server_side',
        'order_column',
        'order_display_column',
        'order_direction',
        'default_search_key',
        'scope',
        'details',
    ];

    public function rows()
    {
        return $this->hasMany(Admin::modelClass('DataRow'))->orderBy('order');
    }

}
