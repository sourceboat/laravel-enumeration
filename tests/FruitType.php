<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static \Sourceboat\Enumeration\Tests\FruitType BERRY()
 * @method static \Sourceboat\Enumeration\Tests\FruitType NUT()
 * @method static \Sourceboat\Enumeration\Tests\FruitType ACCESSORY_FRUIT()
 * @method static \Sourceboat\Enumeration\Tests\FruitType LEGUME()
 */
class FruitType extends Enumeration
{
    protected static $localizationPath = 'test';

    public const BERRY = 'berry';
    public const NUT = 'nut';
    public const ACCESSORY_FRUIT = 'accessory_fruit';
    public const LEGUME = 'legume';
}
