<?php

namespace Sourceboat\Enumeration\Tests;

class LocalizeTest extends TestCase
{
    /**
     * undocumented function summary
     *
     * @return void
     */
    public function testGetCorrectKey(): void
    {
        $this->assertEquals('enums.Sourceboat\\Enumeration\\Tests\\TestEnum.test_1', TestEnum::TEST1()->localized());
    }
}
