<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;
use Sourceboat\Enumeration\Enums\Interfaces\Weighted;
use Sourceboat\Enumeration\Enums\Traits\IsWeighted;

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
class FruitType extends Enumeration implements Weighted
{
    use IsWeighted;

    public const BERRY = 'berry';
    public const NUT = 'nut';
    public const ACCESSORY_FRUIT = 'accessory_fruit';
    public const LEGUME = 'legume';

    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected static $localizationPath = 'test';
}
