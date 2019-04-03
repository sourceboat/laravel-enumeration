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
        $this->assertEquals('moderator', UserRole::MODERATOR()->value());
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
            'moderator',
            'admin',
            'super_admin',
            'user',
        ], UserRole::values());
    }

    /**
     * Check that the generated key using overidden property is correct.
     *
     * @return void
     */
    public function testGetLocalizedValuesFromEnum(): void
    {
        $this->assertEquals([
            'enums.Sourceboat\\Enumeration\\Tests\\UserRole.moderator',
            'enums.Sourceboat\\Enumeration\\Tests\\UserRole.admin',
            'enums.Sourceboat\\Enumeration\\Tests\\UserRole.super_admin',
            'enums.Sourceboat\\Enumeration\\Tests\\UserRole.user',
        ], UserRole::localizedValues());
    }

    /**
     * Check that the generated key using overidden property is correct.
     *
     * @return void
     */
    public function testGetOverriddenLocalizedValuesFromEnum(): void
    {
        $this->assertEquals([
            'test.berry',
            'test.nut',
            'test.accessory_fruit',
            'test.legume',
        ], FruitType::localizedValues());
    }
}
