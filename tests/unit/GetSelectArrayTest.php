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
            'moderator' => 'MODERATOR',
            'admin' => 'ADMIN',
            'super_admin' => 'SUPER_ADMIN',
            'user' => 'USER',
        ], UserRole::toSelectArray());
    }

    /**
     * Check that the keys and values are correct.
     *
     * @return void
     */
    public function testGetLocalizedSelectArrayFromEnum(): void
    {
        $this->assertEquals([
            'moderator' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.moderator',
            'admin' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.admin',
            'super_admin' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.super_admin',
            'user' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.user',
        ], UserRole::toLocalizedSelectArray());
    }

    /**
     * Check that the keys and values are correct.
     *
     * @return void
     */
    public function testGetOverriddenLocalizedSelectArrayFromEnum(): void
    {
        $this->assertEquals([
            'berry' => 'test.berry',
            'nut' => 'test.nut',
            'accessory_fruit' => 'test.accessory_fruit',
            'legume' => 'test.legume',
        ], FruitType::toLocalizedSelectArray());
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
            'admin' => 'ADMIN',
            'super_admin' => 'SUPER_ADMIN',
            'user' => 'USER',
        ], UserRole::toSelectArray([UserRole::MODERATOR()]));
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
            'moderator' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.moderator',
            'admin' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.admin',
            'user' => 'enums.Sourceboat\\Enumeration\\Tests\\UserRole.user',
        ], UserRole::toLocalizedSelectArray([UserRole::SUPER_ADMIN()]));
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
            'berry' => 'test.berry',
            'accessory_fruit' => 'test.accessory_fruit',
            'legume' => 'test.legume',
        ], FruitType::toLocalizedSelectArray([FruitType::NUT()]));
    }
}
