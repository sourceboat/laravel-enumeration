<?php

namespace Sourceboat\Enumeration\Tests;

class GetValuesTest extends TestCase
{
    /**
     * Check that the generated default key is correct.
     *
     * @return void
     */
    public function testGetSingleValue(): void
    {
        $this->assertEquals('test_1', TestEnum::TEST1()->value());
    }

    /**
     * Check that the generated key using overidden property is correct.
     *
     * @depends testGetSingleValue
     * @return void
     */
    public function testGetValuesFromEnum(): void
    {
        $this->assertEquals([
            'test_1',
            'test_2',
            'test_3',
            'test_4',
        ], TestEnum2::values());
    }
}
