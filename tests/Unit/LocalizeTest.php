<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class LocalizeTest extends TestCase
{
    /**
     * Check that the generated default key is correct.
     *
     * @return void
     */
    public function testGetCorrectDefaultKey(): void
    {
        $this->assertEquals(
            'enums.Sourceboat\\Enumeration\\Tests\\UserRole.moderator',
            UserRole::MODERATOR()->localized(),
        );
    }

    /**
     * Check that the generated key using overidden property is correct.
     *
     * @return void
     */
    public function testGetCorrectOverrideKey(): void
    {
        $this->assertEquals('test.berry', FruitType::BERRY()->localized());
    }
}
