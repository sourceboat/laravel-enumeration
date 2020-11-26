<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Exceptions\UndefinedMemberException;

class ModelCastsEnumsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->model = new TestModel();
    }

    /**
     * Check if the default member gets returned from attribute
     * access when the attribute is null (or a value not represented by the enum).
     */
    public function testGetDefaultMemberWhenNotSet(): void
    {
        $this->assertNotNull($this->model->role);
        $this->assertEquals(UserRole::defaultMember(), $this->model->role);
    }

    /**
     * Check if null gets returned from attribute
     * access when the attribute is null and set as nullable.
     */
    public function testGetNullWhenNotSetAndNullable(): void
    {
        $this->assertNull($this->model->type);
        $this->assertNull($this->model->typeCastable);
    }

    /**
     * Check if the validation when setting an enum-property
     * with a wrong value throws an exception.
     */
    public function testSetterValidationWithWrongValue(): void
    {
        $this->model->role = 'test';
        $this->assertEquals(UserRole::defaultMember(), $this->model->role);
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct scalar value throws no exception.
     */
    public function testSetterValidationWithCorrectSkalarValue(): void
    {
        try {
            $this->model->role = 'admin';
            $this->assertTrue(true);
            $this->assertEquals(UserRole::ADMIN(), $this->model->role);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct value of null throws no exception.
     */
    public function testSetterValidationWithCorrectNullValue(): void
    {
        try {
            $this->model->type = FruitType::NUT();
            $this->assertEquals(FruitType::NUT(), $this->model->type);

            $this->model->type = null;
            $this->assertTrue(true);
            $this->assertNull($this->model->type);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct value of null throws no exception.
     */
    public function testSetterValidationWithCorrectNullValueCastable(): void
    {
        try {
            $this->model->typeCastable = FruitType::NUT();
            $this->assertEquals(FruitType::NUT(), $this->model->typeCastable);

            $this->model->typeCastable = null;
            $this->assertTrue(true);
            $this->assertNull($this->model->typeCastable);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }

    /**
     * Check if the validation when setting an enum-property
     * with a correct skalar value throws no exception.
     */
    public function testSetterValidationWithCorrectMember(): void
    {
        try {
            $this->model->role = UserRole::SUPER_ADMIN();
            $this->assertTrue(true);
            $this->assertEquals(UserRole::SUPER_ADMIN(), $this->model->role);
        } catch (UndefinedMemberException $e) {
            $this->assertTrue(false, 'Correct value was rejected');
        }
    }
}
