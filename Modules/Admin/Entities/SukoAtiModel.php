<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SukoAtiModel extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table ;

    public function setTableName($tableName)
    {
        $this->table = $tableName;
    }
    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\SukoAtiModelFactory::new();
    }
}
