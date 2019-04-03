<?php

namespace Sourceboat\Enumeration\Tests;

class GetKeysTest extends TestCase
{
    /**
     * Check that the generated default key is correct.
     *
     * @return void
     */
    public function testGetSingleKey(): void
    {
        $this->assertEquals('MODERATOR', UserRole::MODERATOR()->key());
    }

    /**
     * Check that the generated key using overidden property is correct.
     *
     * @depends testGetSingleKey
     * @return void
     */
    public function testGetKeysFromEnum(): void
    {
        $this->assertEquals([
            'TEST1',
            'TEST2',
            'TEST3',
            'TEST4',
        ], TestEnum2::keys());
    }
}
