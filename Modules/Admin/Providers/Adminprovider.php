<?php

namespace Modules\Admin\Providers;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Modules\Admin\Entities\DataRow;
use Modules\Admin\Entities\DataType;

class Adminprovider
{
    protected $filesystem;

    protected $models = [
        'DataRow'     => DataRow::class,
        'DataType'    => DataType::class,
    ];

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);

    }

    public function model($name)
    {
        return app($this->models[Str::studly($name)]);
    }
    
    public function modelClass($name)
    {
        return $this->models[$name];
    }
    

    
}
