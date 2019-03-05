<?php

namespace Sourceboat\Enumeration\Tests;

class LocalizeTest extends TestCase
{
    /**
     * Check that the generated default key is correct.
     *
     * @return void
     */
    public function testGetCorrectDefaultKey(): void
    {
        $this->assertEquals('enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_1', TestEnum::TEST1()->localized());
    }

    /**
     * Check that the generated key using overidden property is correct.
     *
     * @return void
     */
    public function testGetCorrectOverrideKey(): void
    {
        $this->assertEquals('test.test_1', TestEnum2::TEST1()->localized());
    }
}
