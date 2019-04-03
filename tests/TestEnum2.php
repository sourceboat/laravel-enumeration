<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static \Sourceboat\Enumeration\Tests\UserRole TEST1()
 * @method static \Sourceboat\Enumeration\Tests\UserRole TEST2()
 * @method static \Sourceboat\Enumeration\Tests\UserRole TEST3()
 * @method static \Sourceboat\Enumeration\Tests\UserRole TEST4()
 */
class TestEnum2 extends Enumeration
{
    protected static $localizationPath = 'test';

    public const TEST1 = 'test_1';
    public const TEST2 = 'test_2';
    public const TEST3 = 'test_3';
    public const TEST4 = 'test_4';
}
