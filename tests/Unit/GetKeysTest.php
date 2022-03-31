<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

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
            'BERRY',
            'NUT',
            'ACCESSORY_FRUIT',
            'LEGUME',
        ], FruitType::keys());
    }
}
