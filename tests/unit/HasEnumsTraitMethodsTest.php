<?php

namespace Sourceboat\Enumeration\Tests;

use Eloquent\Enumeration\Exception\UndefinedMemberException;

/**
 * Test All methods defined by HasEnums Trait.
 */
class HasEnumsTraitMethodsTest extends TestCase
{
    public function setUp(): void
    {
        $this->model = new TestModel;
        $this->model2 = new TestModel2;
    }

    public function testGetEnumsArray(): void
    {
        $this->assertEquals([], $this->model2->getEnumsArray());
        $this->assertEquals([
            'role' => UserRole::class,
            'test2' => [ 'nullable' => true, 'enum' => TestEnum2::class ],
        ], $this->model->getEnumsArray());
    }

    public function testIsEnumAttribute(): void
    {
        $this->assertTrue($this->model->isEnumAttribute('role'));
        $this->assertFalse($this->model->isEnumAttribute('test3'));
    }

    public function testGetAttribute(): void
    {
        $this->assertEquals(UserRole::defaultMember(), $this->model->getAttribute('role'));

        $this->model->role = UserRole::SUPER_ADMIN();

        $this->assertEquals(UserRole::SUPER_ADMIN(), $this->model->getAttribute('role'));

        $this->assertNull($this->model->getAttribute('test2'));
        $this->assertNull($this->model->getAttribute('roles'));
    }

    public function testSetAttribute(): void
    {
        try {
            $this->model->setAttribute('role', 'test');
            $this->assertTrue(false, 'undefined value "test" was set.');
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(true);
        }

        try {
            $this->model->setAttribute('role', null);
            $this->assertTrue(false, 'undefined value "null" was set.');
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(true);
        }

        try {
            $this->model->setAttribute('role', UserRole::ADMIN());
            $this->assertTrue(true);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value "UserRole::ADMIN()" was rejected');
        }

        try {
            $this->model->setAttribute('role', 'moderator');
            $this->assertTrue(true);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value "moderator" was rejected');
        }

        try {
            $this->model->setAttribute('test2', null);
            $this->assertTrue(true);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value "null" was rejected');
        }

        try {
            $this->model->setAttribute('test2', TestEnum2::TEST3());
            $this->assertTrue(true);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value "TestEnum2::TEST3()" was rejected');
        }

        try {
            $this->model->setAttribute('test3', 'test5');
            $this->assertTrue(true);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Exception thrown by setting non-enum-property!');
        }
    }
}
