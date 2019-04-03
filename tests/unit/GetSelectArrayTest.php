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
            'test_1' => 'test.test_1',
            'test_3' => 'test.test_3',
            'test_4' => 'test.test_4',
        ], TestEnum2::toLocalizedSelectArray([TestEnum2::TEST2()]));
    }
}
