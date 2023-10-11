<?php

namespace Modules\Admin\Database\Types\Postgresql;

use Modules\Admin\Database\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    public const NAME = 'character varying';
    public const DBTYPE = 'varchar';
}
