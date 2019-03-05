<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static \Sourceboat\Enumeration\Tests\TestEnum TEST1()
 * @method static \Sourceboat\Enumeration\Tests\TestEnum TEST2()
 * @method static \Sourceboat\Enumeration\Tests\TestEnum TEST3()
 * @method static \Sourceboat\Enumeration\Tests\TestEnum TEST4()
 */
class TestEnum extends Enumeration
{
    public const TEST1 = 'test_1';
    public const TEST2 = 'test_2';
    public const TEST3 = 'test_3';
    public const TEST4 = 'test_4';
}
