<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Database\Eloquent\Model;
use Sourceboat\Enumeration\Casts\Enum;

class TestModel extends Model
{
    /**
     * @var array<string>
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $casts = [
        'role' => Enum::class . ':' . UserRole::class . ',0',
        'type' => Enum::class . ':' . FruitType::class,
        'typeCastable' => FruitType::class,
    ];
}
