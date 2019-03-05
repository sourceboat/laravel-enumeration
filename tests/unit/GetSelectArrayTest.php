<?php

namespace Sourceboat\Enumeration\Tests;

class GetSelectArrayTest extends TestCase
{
    /**
     * Check that the keys and values are correct.
     *
     * @return void
     */
    public function testGetSelectArrayFromEnum(): void
    {
        $this->assertEquals([
            'test_1' => 'TEST1',
            'test_2' => 'TEST2',
            'test_3' => 'TEST3',
            'test_4' => 'TEST4',
        ], TestEnum::toSelectArray());
    }

    /**
     * Check that the keys and values are correct.
     *
     * @return void
     */
    public function testGetLocalizedSelectArrayFromEnum(): void
    {
        $this->assertEquals([
            'test_1' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_1',
            'test_2' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_2',
            'test_3' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_3',
            'test_4' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_4',
        ], TestEnum::toLocalizedSelectArray());
    }

    /**
     * Check that the keys and values are correct.
     *
     * @return void
     */
    public function testGetOverriddenLocalizedSelectArrayFromEnum(): void
    {
        $this->assertEquals([
            'test_1' => 'test.test_1',
            'test_2' => 'test.test_2',
            'test_3' => 'test.test_3',
            'test_4' => 'test.test_4',
        ], TestEnum2::toLocalizedSelectArray());
    }

    /**
     * Check that the keys and values are correct.
     *
     * @depends testGetSelectArrayFromEnum
     * @return void
     */
    public function testGetSelectArrayFromEnumWithBlacklist(): void
    {
        $this->assertEquals([
            'test_2' => 'TEST2',
            'test_3' => 'TEST3',
            'test_4' => 'TEST4',
        ], TestEnum::toSelectArray([TestEnum::TEST1()]));
    }

    /**
     * Check that the keys and values are correct.
     *
     * @depends testGetLocalizedSelectArrayFromEnum
     * @return void
     */
    public function testGetLocalizedSelectArrayFromEnumWithBlacklist(): void
    {
        $this->assertEquals([
            'test_1' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_1',
            'test_2' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_2',
            'test_4' => 'enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_4',
        ], TestEnum::toLocalizedSelectArray([TestEnum::TEST3()]));
    }

    /**
     * Check that the keys and values are correct.
     *
     * @depends testGetOverriddenLocalizedSelectArrayFromEnum
     * @return void
     */
    public function testGetOverriddenLocalizedSelectArrayFromEnumWithBlacklist(): void
    {
        $this->assertEquals([
            'test_1' => 'test.test_1',
            'test_3' => 'test.test_3',
            'test_4' => 'test.test_4',
        ], TestEnum2::toLocalizedSelectArray([TestEnum2::TEST2()]));
    }
}
