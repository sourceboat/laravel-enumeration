<?php

namespace Sourceboat\Enumeration\Tests;

class ToStringTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals('test_1', TestEnum::TEST1()->__toString());
        $this->assertEquals('test_1', (string) TestEnum::TEST1());
    }
}
