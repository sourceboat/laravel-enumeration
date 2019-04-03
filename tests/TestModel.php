<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Traits\HasEnums;

class TestModel extends Model
{
    use HasEnums;

    protected $enums = [
        'role' => UserRole::class,
        'test2' => [ 'nullable' => true, 'enum' => TestEnum2::class ],
    ];
}
