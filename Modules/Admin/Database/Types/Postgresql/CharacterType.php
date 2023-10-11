<?php

namespace Modules\Admin\Database\Types\Postgresql;

use Modules\Admin\Database\Types\Common\CharType;

class CharacterType extends CharType
{
    public const NAME = 'character';
    public const DBTYPE = 'bpchar';
}
