<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Models\Traits\HasEnums;

class TestModel extends Model
{
    use HasEnums;

    protected $enums = [
        'role' => UserRole::class,
        'type' => [ 'nullable' => true, 'enum' => FruitType::class ],
    ];
}
