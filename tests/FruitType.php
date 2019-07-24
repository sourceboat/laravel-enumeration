<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static self BERRY()
 * @method static self NUT()
 * @method static self ACCESSORY_FRUIT()
 * @method static self LEGUME()
 * @method bool isBerry()
 * @method bool isNut()
 * @method bool isAccessory_Fruit()
 * @method bool isLegume()
 */
class FruitType extends Enumeration
{
    protected static $localizationPath = 'test';

    public const BERRY = 'berry';
    public const NUT = 'nut';
    public const ACCESSORY_FRUIT = 'accessory_fruit';
    public const LEGUME = 'legume';
}
