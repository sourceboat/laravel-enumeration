<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;
use Sourceboat\Enumeration\Enums\Interfaces\Configurable;
use Sourceboat\Enumeration\Enums\Traits\IsConfigurable;

/**
 * @method static self OPTION_ONE()
 * @method static self OPTION_TWO()
 * @method static self OPTION_THREE()
 * @method bool isOPTION_ONE()
 * @method bool isOPTION_TWO()
 * @method bool isOPTION_THREE()
 */
class ConfigurableEnum extends Enumeration implements Configurable
{
    use IsConfigurable;

    public const OPTION_ONE = 'option-one';
    public const OPTION_TWO = 'option-two';
    public const OPTION_THREE = 'option-three';
}
